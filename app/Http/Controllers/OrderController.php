<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OrderController extends Controller
{
    // Mapping layanan ke tabel rate
    private $tableMap = [
        'PRIORITY'    => 'dhl_rate',
        'FedEx'       => 'fedex_rate',
        'REGULER'     => 'singpost_rate',
        'US REGULER'  => 'usps_rate',
        'FAST ASIAN'  => 'tlx_rate',
        'FLASH'       => 'aramex_rate',
        'FLASH AUSSY' => 'tge_rate',
    ];

    /**
     * Daftar negara yang TIDAK dikenakan pajak tambahan Aramex (FLASH)
     */
    private $aramexExceptionCountries = [
        'Afghanistan',
        'Armenia',
        'Azerbaijan',
        'Brunei',
        'Cambodia',
        'China',
        'Hong Kong',
        'Indonesia',
        'Japan',
        'Kazakhstan',
        'Kyrgyzstan',
        'Laos',
        'Macau',
        'Malaysia',
        'Mongolia',
        'Myanmar',
        'Philippines',
        'Singapore',
        'South Korea',
        'Taiwan',
        'Tajikistan',
        'Thailand',
        'Timor-Leste',
        'Turkmenistan',
        'Uzbekistan',
        'Vietnam',
        'Australia',
        'New Zealand',
        'Fiji'
    ];

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $query = Shipment::query();

        if ($request->filled('service') && $request->service !== 'all') {
            $query->where('service', $request->service);
        }
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status_pengerjaan', $request->status);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('tracking_number', 'LIKE', "%$search%")
                    ->orWhere('negara', 'LIKE', "%$search%")
                    ->orWhere('nama_customer', 'LIKE', "%$search%")
                    ->orWhere('nama_penerima', 'LIKE', "%$search%");
            });
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $stats = [
            'total'     => Shipment::where('status_pengerjaan', '!=', 'Cancelled')->count(),
            'revenue'   => Shipment::where('status_pengerjaan', '!=', 'Cancelled')->sum('charge_idr'),
            'pending'   => Shipment::where('status_pengerjaan', 'Pending')->count(),
            'delivered' => Shipment::where('status_pengerjaan', 'Delivered')->count(),
        ];

        $shipments = $query->orderBy('id', 'desc')->paginate(15);
        $shipments->load('invoices');

        $countries = DB::table('countries')->orderBy('country_name')->get();

        return view('admin.orders', compact('shipments', 'stats', 'countries'));
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('selected_ids', []);
        if (empty($ids)) {
            return redirect()->back()->with('error', 'Tidak ada shipment yang dipilih.');
        }
        Shipment::whereIn('id', $ids)->delete();

        $query = http_build_query([
            'service'   => $request->_service,
            'status'    => $request->_status,
            'search'    => $request->_search,
            'date_from' => $request->_date_from,
            'date_to'   => $request->_date_to,
        ]);
        return redirect()->route('orders', $query)->with('success', count($ids) . ' pengiriman berhasil dihapus.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id'              => 'required|exists:shipments,id',
            'tracking_number' => 'required|string',
            'user_id'         => 'nullable|integer',
            'service'         => 'required|string',
            'charge_idr'      => 'nullable|numeric|min:0',
            'status'          => 'required|in:Pending,Processing,Delivered,Cancelled',
            'negara'          => 'nullable|string',
            'berat_fisik'     => 'nullable|numeric|min:0',
            'panjang'         => 'nullable|numeric|min:0',
            'lebar'           => 'nullable|numeric|min:0',
            'tinggi'          => 'nullable|numeric|min:0',
        ]);

        $shipment = Shipment::findOrFail($request->id);

        // Simpan nilai lama untuk field yang mempengaruhi DDP (negara, declare_value_usd)
        $oldNegara = $shipment->negara;
        $oldDeclareValue = $shipment->declare_value_usd;

        // Update field dasar
        $shipment->tracking_number   = $request->tracking_number;
        $shipment->user_id           = $request->user_id;
        $shipment->service           = $request->service;
        $shipment->status_pengerjaan = $request->status;

        if ($request->has('negara'))     $shipment->negara     = $request->negara;
        if ($request->has('berat_fisik')) $shipment->berat_fisik = $request->berat_fisik;
        if ($request->has('panjang'))    $shipment->panjang    = $request->panjang;
        if ($request->has('lebar'))      $shipment->lebar      = $request->lebar;
        if ($request->has('tinggi'))     $shipment->tinggi     = $request->tinggi;

        // Hitung ulang volumetrik dan berat dibebankan
        $panjang    = $shipment->panjang    ?? 0;
        $lebar      = $shipment->lebar      ?? 0;
        $tinggi     = $shipment->tinggi     ?? 0;
        $beratFisik = $shipment->berat_fisik ?? 0;

        // Hitung volumetrik terlebih dahulu
        $volumetrik = ($panjang * $lebar * $tinggi) / 5000;

        // Tentukan berat dibebankan berdasarkan service
        if ($shipment->service === 'REGULER') {
            $beratDibebankan = $beratFisik; // hanya berat fisik
        } else {
            $beratDibebankan = max($beratFisik, $volumetrik);
        }

        $shipment->volumetrik       = round($volumetrik, 3);
        $shipment->berat_dibebankan = round($beratDibebankan, 3);

        // Tentukan harga
        if ($request->filled('charge_idr') && $request->charge_idr > 0) {
            $shipment->charge_idr = $request->charge_idr;
        } else {
            $result = $this->getPriceFromTable($shipment->service, $shipment->negara, $beratDibebankan);
            if (!empty($result['price']) && $result['price'] > 0) {
                $shipment->charge_idr = $result['price'];
            }
        }

        // 🔽 HITUNG MODAL DARI RATES & SIMPAN
        $modalResult = $this->getModalFromTable($shipment->service, $shipment->negara, $beratDibebankan);
        $shipment->modal = $modalResult['modal'] ?? 0;

        $shipment->save();

        // Sinkronisasi ke invoice item
        $invoiceItem = InvoiceItem::where('shipment_id', $shipment->id)->first();
        if ($invoiceItem) {
            // Update ongkir di item
            $invoiceItem->ongkir = $shipment->charge_idr;
            $invoiceItem->save();

            // Recalculate invoice (subtotal, DDP, grand total)
            Invoice::recalculate($invoiceItem->invoice_id);
        }

        return response()->json(['success' => true]);
    }

    public function markDelivered(Request $request)
    {
        $request->validate(['id' => 'required|exists:shipments,id']);
        $shipment = Shipment::findOrFail($request->id);
        $shipment->status_pengerjaan = 'Delivered';
        $shipment->save();
        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $shipment = Shipment::findOrFail($id);
        $shipment->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        return redirect()->back()->with('success', 'Shipment berhasil dihapus.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'selected_shipments' => 'required|array',
            'selected_shipments.*' => 'exists:shipments,id',
        ]);

        $invoice = Invoice::create([
            'nomor_inv' => $this->generateInvoiceNumber(),
            'nama_customer' => auth()->user()->name,
            'email_customer' => auth()->user()->email,
            'status' => 'Unpaid',
            'created_by' => auth()->id(),
        ]);

        foreach ($request->selected_shipments as $shipmentId) {
            $shipment = Shipment::find($shipmentId);
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'shipment_id' => $shipmentId,
                'nama_penerima' => $shipment->nama_penerima,
                'ongkir' => $shipment->charge_idr,
            ]);
        }

        // Hitung ulang semua komponen
        Invoice::recalculate($invoice->id);

        return redirect()->route('invoice.detail', hashid_encode($invoice->id))
            ->with('success', 'Invoice berhasil dibuat.');
    }

    public function calculatePrice(Request $request)
    {
        $request->validate([
            'service' => 'required|string',
            'negara'  => 'required|string',
            'berat'   => 'required|numeric|min:0',
        ]);

        $result = $this->getPriceFromTable($request->service, $request->negara, $request->berat);
        return response()->json($result);
    }

    // ─── HELPER: AMBIL MODAL DARI RATES ──────────────────────

    /**
     * Ambil modal dari tabel rate berdasarkan service, negara, dan berat.
     */
    private function getModalFromTable($service, $negara, $berat)
    {
        $table = $this->tableMap[$service] ?? null;
        if (!$table) return ['modal' => 0, 'out_of_range' => false];

        $country = DB::table('countries')->where('country_name', $negara)->first();
        if (!$country) return ['modal' => 0, 'out_of_range' => false];

        $destId = $country->id;

        if (!Schema::hasTable($table)) {
            return ['modal' => 0, 'out_of_range' => false];
        }

        $rate = DB::table($table)
            ->where('origin_country_id', 1)
            ->where('destination_country_id', $destId)
            ->where('weight_kg', '>=', $berat)
            ->orderBy('weight_kg', 'asc')
            ->first();

        if ($rate) {
            return ['modal' => (float) $rate->modal, 'out_of_range' => false];
        }

        return ['modal' => 0, 'out_of_range' => true];
    }

    /**
     * Mendapatkan harga dari tabel rate berdasarkan service, negara, dan berat.
     * Mengambil rate dengan weight_kg >= berat (bracket berikutnya).
     */
    private function getPriceFromTable($service, $negara, $berat)
    {
        $table = $this->tableMap[$service] ?? null;
        if (!$table) return ['price' => 0, 'out_of_range' => false, 'max_weight' => null];

        $country = DB::table('countries')->where('country_name', $negara)->first();
        if (!$country) return ['price' => 0, 'out_of_range' => false, 'max_weight' => null];

        $destId = $country->id;

        if (!Schema::hasTable($table)) {
            return ['price' => 0, 'out_of_range' => false, 'max_weight' => null];
        }

        $rate = DB::table($table)
            ->where('origin_country_id', 1)
            ->where('destination_country_id', $destId)
            ->where('weight_kg', '>=', $berat)
            ->orderBy('weight_kg', 'asc')
            ->first();

        if ($rate) {
            return ['price' => (float) $rate->price, 'out_of_range' => false, 'max_weight' => null];
        }

        $maxWeight = DB::table($table)
            ->where('origin_country_id', 1)
            ->where('destination_country_id', $destId)
            ->max('weight_kg');

        return ['price' => 0, 'out_of_range' => true, 'max_weight' => $maxWeight];
    }

    /**
     * Hitung pajak tambahan untuk layanan Aramex (FLASH)
     */
    private function getAramexSurcharge($negara, $berat)
    {
        if (in_array($negara, $this->aramexExceptionCountries)) {
            return 0.0;
        }

        if ($berat <= 2.0) {
            return 100000.0;
        } else {
            return 50000.0 * $berat;
        }
    }

    public function getAvailableServices(Request $request)
    {
        $request->validate([
            'negara' => 'required|string',
            'weight' => 'required|numeric|min:0',
            'physical_weight' => 'nullable|numeric|min:0',
        ]);

        $country = DB::table('countries')->where('country_name', $request->negara)->first();
        if (!$country) {
            return response()->json(['services' => []]);
        }

        $weight = (float) $request->weight;
        $physicalWeight = (float) ($request->physical_weight ?? $weight);

        $vendors = [
            ['name' => 'PRIORITY',    'table' => 'dhl_rate',     'maxWeight' => 30],
            ['name' => 'FedEx',       'table' => 'fedex_rate',   'maxWeight' => 30],
            ['name' => 'US REGULER',  'table' => 'usps_rate',    'maxWeight' => 2.0],
            ['name' => 'REGULER',     'table' => 'singpost_rate', 'maxWeight' => 2.0],
            ['name' => 'FAST ASIAN',  'table' => 'tlx_rate',     'maxWeight' => 30.0],
            ['name' => 'FLASH',       'table' => 'aramex_rate',  'maxWeight' => 20.0],
            ['name' => 'FLASH AUSSY', 'table' => 'tge_rate',     'maxWeight' => 30.0],
        ];

        $available = [];
        foreach ($vendors as $vendor) {
            if ($vendor['name'] === 'REGULER') {
                if ($physicalWeight > $vendor['maxWeight']) continue;
                $checkWeight = $physicalWeight;
            } else {
                if ($weight > $vendor['maxWeight']) continue;
                $checkWeight = $weight;
            }

            if (!Schema::hasTable($vendor['table'])) continue;

            $hasRate = DB::table($vendor['table'])
                ->where('origin_country_id', 1)
                ->where('destination_country_id', $country->id)
                ->where('weight_kg', '>=', $checkWeight)
                ->exists();

            if ($hasRate) {
                $available[] = $vendor['name'];
            }
        }

        return response()->json(['services' => $available]);
    }

    private function generateInvoiceNumber()
    {
        $last = Invoice::latest()->first();
        $number = $last ? intval(substr($last->nomor_inv, -4)) + 1 : 1;
        return 'INV-' . date('ymd') . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}
