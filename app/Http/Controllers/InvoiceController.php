<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Traits\LogsActivity;
use Illuminate\Support\Facades\DB;
use App\Services\ExchangeRateService;

class InvoiceController extends Controller
{
    use LogsActivity;

    public function __construct()
    {
        $this->middleware('auth');
        // Permission akan diatur di route
    }

    /**
     * ============================================================
     * 1. DAFTAR INVOICE (dengan filter & pagination)
     * ============================================================
     */
    public function index(Request $request)
    {
        $role = auth()->user()->role ?? '';
        if (!in_array($role, ['admin', 'owner', 'dev'])) {
            return redirect()->route('home')->with('error', 'Unauthorized access');
        }

        $status = $request->get('status', 'all');
        $search = trim($request->get('search', ''));

        $query = Invoice::query();

        if ($status !== 'all') {
            $query->where('status', $status);
        }
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_inv', 'LIKE', "%{$search}%")
                    ->orWhere('nama_customer', 'LIKE', "%{$search}%");
            });
        }

        $invoices = $query->orderBy('id', 'desc')->paginate(15);
        $invoices->appends($request->query());

        // Hitung jumlah paket per invoice
        foreach ($invoices as $inv) {
            $inv->jumlah_paket = InvoiceItem::where('invoice_id', $inv->id)->count();
        }

        $stats = [
            'total'        => Invoice::count(),
            'total_nilai'  => Invoice::sum('grand_total'),
            'total_unpaid' => Invoice::where('status', 'Unpaid')->count(),
            'total_lunas'  => Invoice::where('status', 'Paid')->sum('grand_total'),
        ];

        return view('admin.invoices', [
            'invoices'      => $invoices,
            'stats'         => $stats,
            'filterStatus'  => $status,
            'search'        => $search,
            'currentPage'   => $invoices->currentPage(),
            'totalPages'    => $invoices->lastPage(),
            'totalRows'     => $invoices->total(),
        ]);
    }

    /**
     * ============================================================
     * 2. FORM BUAT INVOICE BARU
     * ============================================================
     */
    public function createInvoice(Request $request)
    {
        $role = auth()->user()->role ?? '';
        if (!in_array($role, ['admin', 'dev', 'owner'])) {
            return redirect()->route('home')->with('error', 'Unauthorized');
        }

        $preSelectedShipmentId = $request->query('shipment_id');
        $preSelectedShipment = null;
        if ($preSelectedShipmentId) {
            $preSelectedShipment = DB::table('shipments')->where('id', $preSelectedShipmentId)->first();
        }

        $exchangeRateService = new ExchangeRateService();
        $usdRate = $exchangeRateService->getUsdToIdrRate();

        $ddpPercent = Setting::get('ddp_percent', 19);

        // Ambil customer yang memiliki shipment Pending dan belum di-invoice
        $customers = DB::table('users as u')
            ->select('u.id', 'u.name', 'u.email', 'u.phone', 'u.company_name')
            ->whereIn(DB::raw('u.name COLLATE utf8mb4_unicode_ci'), function ($q) {
                $q->select(DB::raw('DISTINCT nama_customer COLLATE utf8mb4_unicode_ci'))
                    ->from('shipments')
                    ->where('status_pengerjaan', 'Pending')
                    ->whereNotIn('id', function ($sub) {
                        $sub->select(DB::raw('CAST(ii.shipment_id AS UNSIGNED)'))
                            ->from('invoice_items as ii')
                            ->whereNotNull('ii.shipment_id');
                    });
            })
            ->orderBy('u.name')
            ->get();

        return view('admin.create_invoice', compact('customers', 'preSelectedShipment', 'usdRate', 'ddpPercent'));
    }

    /**
     * ============================================================
     * 3. SIMPAN INVOICE BARU
     * ============================================================
     */
    public function storeInvoice(Request $request)
    {
        $role = auth()->user()->role ?? '';
        if (!in_array($role, ['admin', 'dev', 'owner'])) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $request->validate([
            'user_id'         => 'required|exists:users,id',
            'shipment_ids'    => 'required|array|min:1',
            'shipment_ids.*'  => 'integer',
        ]);

        $userId = $request->user_id;
        $user = User::find($userId);
        if (!$user) {
            return redirect()->back()->with('error', 'Customer tidak ditemukan.');
        }

        $customerName  = $user->name;
        $customerEmail = $user->email;
        $shipmentIds   = $request->shipment_ids;
        $shipments     = Shipment::whereIn('id', $shipmentIds)->get();

        $subtotal = $shipments->sum('charge_idr');

        // Hitung DDP untuk shipment REGULER ke US/Canada
        $ddpCountries = ['United States', 'USA', 'US', 'United States of America & Territories'];
        $totalDeclareUSD = 0;
        foreach ($shipments as $ship) {
            if ($ship->service === 'REGULER' && in_array($ship->negara, $ddpCountries)) {
                $totalDeclareUSD += (float) $ship->declare_value_usd;
            }
        }

        $ddp = 0;
        if ($totalDeclareUSD > 0) {
            $exchangeRateService = new ExchangeRateService();
            $usdRate = $exchangeRateService->getUsdToIdrRate();
            $ddpPercent = Setting::get('ddp_percent', 19);
            $ddp = round($totalDeclareUSD * $usdRate * ($ddpPercent / 100), 2);
        }

        $grandTotal = $subtotal + $ddp;

        $date   = date('ymd');
        $random = strtoupper(substr(uniqid(), -4));
        $nomorInv = "INV/{$date}/{$random}";

        DB::beginTransaction();
        try {
            $invoiceId = DB::table('invoices')->insertGetId([
                'nomor_inv'       => $nomorInv,
                'nama_customer'   => $customerName,
                'email_customer'  => $customerEmail,
                'subtotal'        => $subtotal,
                'ddp'             => $ddp,
                'war_risk_charge' => 0,
                'aramex_surcharge' => 0,
                'grand_total'     => $grandTotal,
                'status'          => 'Unpaid',
                'created_by'      => auth()->id(),
                'created_at'      => now(),
            ]);

            foreach ($shipments as $shipment) {
                DB::table('invoice_items')->insert([
                    'invoice_id'    => $invoiceId,
                    'shipment_id'   => $shipment->id,
                    'nama_penerima' => $shipment->nama_penerima ?? '-',
                    'ongkir'        => $shipment->charge_idr,
                    'created_at'    => now(),
                ]);
            }

            Invoice::recalculate($invoiceId);
            DB::commit();
            return redirect()->route('admin.invoices.index')->with('flash_inv', "Invoice {$nomorInv} berhasil dibuat.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan invoice: ' . $e->getMessage());
        }
    }

    /**
     * ============================================================
     * 4. FORM EDIT INVOICE
     * ============================================================
     */
    public function editInvoice($hashid)
    {
        $id = hashid_decode($hashid);
        if (!$id) abort(404);

        $role = auth()->user()->role ?? '';
        if (!in_array($role, ['admin', 'dev', 'owner'])) {
            return redirect()->route('home')->with('error', 'Unauthorized');
        }

        $invoice = Invoice::findOrFail($id);
        $items = InvoiceItem::where('invoice_id', $id)->get();
        $shipmentIds = $items->pluck('shipment_id')->toArray();
        $shipments = DB::table('shipments')->whereIn('id', $shipmentIds)->get();
        $customers = DB::table('users')->orderBy('name')->get();

        return view('admin.edit_invoice', compact('invoice', 'items', 'shipments', 'customers'));
    }

    /**
     * ============================================================
     * 5. UPDATE INVOICE (termasuk distribusi subtotal)
     * ============================================================
     */
    public function updateInvoice(Request $request, $hashid)
    {
        $id = hashid_decode($hashid);
        if (!$id) abort(404);

        $role = auth()->user()->role ?? '';
        if (!in_array($role, ['admin', 'dev', 'owner'])) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $request->validate([
            'nama_customer' => 'required|string',
            'email_customer' => 'required|email',
            'subtotal'      => 'required|numeric|min:0',
            'status'        => 'required|in:Unpaid,Paid',
        ]);

        $invoice = Invoice::findOrFail($id);
        $invoice->nama_customer = $request->nama_customer;
        $invoice->email_customer = $request->email_customer;
        $invoice->status = $request->status;

        $newSubtotal = (float) $request->subtotal;
        $oldSubtotal = (float) $invoice->subtotal;
        $invoice->subtotal = $newSubtotal;

        // DDP tetap (tidak berubah)
        $ddp = (float) $invoice->ddp;
        $invoice->grand_total = $newSubtotal + $ddp;
        $invoice->save();

        // Jika subtotal berubah, distribusikan secara proporsional ke item
        if ($oldSubtotal > 0 && $oldSubtotal != $newSubtotal) {
            $ratio = $newSubtotal / $oldSubtotal;
            $items = InvoiceItem::where('invoice_id', $invoice->id)->get();
            foreach ($items as $item) {
                $oldOngkir = (float) $item->ongkir;
                $newOngkir = round($oldOngkir * $ratio, 2);
                $item->ongkir = $newOngkir;
                $item->save();

                // Update shipment terkait
                if ($item->shipment_id) {
                    $shipment = Shipment::find($item->shipment_id);
                    if ($shipment) {
                        $shipment->charge_idr = $newOngkir;
                        $shipment->save();
                    }
                }
            }
        }

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.invoices.index')->with('flash_inv', 'Invoice berhasil diupdate.');
    }

    /**
     * ============================================================
     * 6. TANDAI INVOICE LUNAS
     * ============================================================
     */
    public function markInvoicePaid(Request $request, $hashid)
    {
        $id = hashid_decode($hashid);
        if (!$id) abort(404);

        $role = auth()->user()->role ?? '';
        if (!in_array($role, ['admin', 'owner', 'dev'])) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $invoice = Invoice::findOrFail($id);

        if ($invoice->status !== 'Unpaid') {
            return redirect()->back()->with('error', 'Invoice sudah lunas.');
        }

        DB::beginTransaction();
        try {
            $invoice->status = 'Paid';
            $invoice->save();

            $items = InvoiceItem::where('invoice_id', $invoice->id)->get();
            foreach ($items as $item) {
                if ($item->shipment_id) {
                    DB::table('shipments')
                        ->where('id', $item->shipment_id)
                        ->where('status_pengerjaan', 'Pending')
                        ->update(['status_pengerjaan' => 'Processing']);
                }
            }

            DB::commit();
            return redirect()->route('admin.invoices.index')
                ->with('flash_inv', 'Invoice berhasil ditandai Lunas.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui invoice.');
        }
    }

    /**
     * ============================================================
     * 7. HAPUS INVOICE
     * ============================================================
     */
    public function deleteInvoice($hashid)
    {
        $id = hashid_decode($hashid);
        if (!$id) abort(404);

        $role = auth()->user()->role ?? '';
        if (!in_array($role, ['admin', 'owner', 'dev'])) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $invoice = Invoice::findOrFail($id);
        DB::beginTransaction();
        try {
            InvoiceItem::where('invoice_id', $invoice->id)->delete();
            $invoice->delete();
            DB::commit();
            return redirect()->route('admin.invoices.index')
                ->with('flash_inv', 'Invoice berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus invoice.');
        }
    }

    /**
     * ============================================================
     * 8. AJAX: AMBIL SHIPMENT BERDASARKAN CUSTOMER
     * ============================================================
     */
    public function ajaxShipmentsByCustomer(Request $request)
    {
        $userId = $request->get('user_id');
        if (!$userId) {
            return response()->json([]);
        }
        $shipments = DB::table('shipments')
            ->where('user_id', $userId)
            ->where('status_pengerjaan', 'Pending')
            ->whereNotIn('id', function ($q) {
                $q->select(DB::raw('CAST(shipment_id AS UNSIGNED)'))
                    ->from('invoice_items')
                    ->whereNotNull('shipment_id');
            })
            ->select('id', 'tracking_number', 'nama_penerima', 'negara', 'service', 'berat_dibebankan', 'charge_idr', 'content', 'declare_value_usd')
            ->get();
        return response()->json($shipments);
    }

    // ============================================================
    // METHOD YANG SUDAH ADA SEBELUMNYA (tetap dipertahankan)
    // ============================================================

    /**
     * Tampilkan detail invoice (public)
     */
    public function show($hashid)
    {
        $id = hashid_decode($hashid);
        if (!$id) abort(404);

        $invoice = Invoice::with('items')->findOrFail($id);
        $items = $invoice->items;
        $shipmentIds = $items->pluck('shipment_id')->toArray();
        $shipments = DB::table('shipments')->whereIn('id', $shipmentIds)->get();

        $shipper = DB::table('users')->where('name', $invoice->nama_customer)->first();
        $shipper_name    = $shipper->name ?? $invoice->nama_customer;
        $shipper_email   = $shipper->email ?? ($invoice->email_customer ?? '—');
        $shipper_phone   = $shipper->phone ?? ($shipments->first()->phone_customer ?? '—');
        $shipper_company = $shipper->company_name ?? '';

        $total_berat  = $shipments->sum('berat_dibebankan');
        $total_usd    = $shipments->sum('declare_value_usd');

        $calc_subtotal = $invoice->subtotal;
        $calc_war_risk = $invoice->war_risk_charge;
        $calc_ddp      = $invoice->ddp;
        $calc_grand    = $invoice->grand_total;

        $isAdmin = in_array(auth()->user()->role ?? '', ['admin', 'dev', 'owner']);
        $ddpPercent = Setting::get('ddp_percent', 19);

        return view('invoice.detail', compact(
            'invoice',
            'shipments',
            'items',
            'shipper_name',
            'shipper_email',
            'shipper_phone',
            'shipper_company',
            'total_berat',
            'total_usd',
            'calc_subtotal',
            'calc_war_risk',
            'calc_ddp',
            'calc_grand',
            'isAdmin',
            'ddpPercent'
        ));
    }

    /**
     * Update invoice (via AJAX dari edit_invoice)
     */
    public function update(Request $request, $hashid)
    {
        $id = hashid_decode($hashid);
        if (!$id) abort(404);

        $invoice = Invoice::findOrFail($id);

        $request->validate([
            'nama_customer' => 'required|string',
            'email_customer' => 'required|email',
            'subtotal' => 'required|numeric|min:0',
            'ddp' => 'nullable|numeric|min:0',
            'grand_total' => 'required|numeric|min:0',
            'status' => 'required|in:Unpaid,Paid',
        ]);

        $invoice->nama_customer = $request->nama_customer;
        $invoice->email_customer = $request->email_customer;
        $invoice->subtotal = $request->subtotal;
        $invoice->ddp = $request->ddp;
        $invoice->grand_total = $request->grand_total;
        $invoice->status = $request->status;
        $invoice->save();

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Invoice berhasil diupdate.');
    }

    /**
     * Mark as paid (alternatif, via GET)
     */
    public function markAsPaid($hashid)
    {
        $id = hashid_decode($hashid);
        if (!$id) abort(404);

        $invoice = Invoice::findOrFail($id);
        $invoice->status = 'Paid';
        $invoice->save();

        return redirect()->back()->with('success', 'Invoice ditandai sebagai Lunas.');
    }

    /**
     * Hapus invoice (alternatif, via GET)
     */
    public function destroy($hashid)
    {
        $id = hashid_decode($hashid);
        if (!$id) abort(404);

        $invoice = Invoice::findOrFail($id);
        $invoice->items()->delete();
        $invoice->delete();

        return redirect()->route('admin.invoices.index')->with('success', 'Invoice berhasil dihapus.');
    }

    // ============================================================
    // HELPER
    // ============================================================

    private function generateInvoiceNumber()
    {
        $last = Invoice::latest()->first();
        $number = $last ? intval(substr($last->nomor_inv, -4)) + 1 : 1;
        return 'INV-' . date('ymd') . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}
