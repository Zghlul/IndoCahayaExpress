<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use App\Traits\LogsActivity;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;

class InvoiceController extends Controller
{
    use LogsActivity;
    
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('admin');
    }

    public function create()
    {
        $shipments = Shipment::doesntHave('invoice')->get();
        return view('admin.create_invoice', compact('shipments'));
    }

    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'shipment_ids' => 'required|array|min:1',
            'shipment_ids.*' => 'exists:shipments,id',
            'nama_customer' => 'required|string',
            'email_customer' => 'required|email',
            'catatan' => 'nullable|string',
        ]);

        $shipmentIds = $request->shipment_ids;
        $shipments = Shipment::whereIn('id', $shipmentIds)->get();

        // Hitung subtotal dari charge_idr
        $subtotal = $shipments->sum('charge_idr');

        // Buat invoice baru
        $invoice = Invoice::create([
            'nomor_inv' => $this->generateInvoiceNumber(),
            'nama_customer' => $request->nama_customer,
            'email_customer' => $request->email_customer,
            'subtotal' => $subtotal,
            'ddp' => 0, // sementara 0, akan dihitung ulang
            'grand_total' => $subtotal,
            'status' => 'Unpaid',
            'created_by' => auth()->id(),
            'catatan' => $request->catatan,
        ]);

        // Buat invoice_items
        foreach ($shipments as $shipment) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'shipment_id' => $shipment->id,
                'nama_penerima' => $shipment->nama_penerima,
                'ongkir' => $shipment->charge_idr,
            ]);
        }

        // Hitung ulang (termasuk DDP)
        Invoice::recalculate($invoice->id);

        return redirect()->route('invoice.detail', hashid_encode($invoice->id))
                         ->with('success', 'Invoice berhasil dibuat.');
    }

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
    
    // Gunakan data dari invoice (sudah tersimpan)
    $calc_subtotal       = $invoice->subtotal;
    $calc_war_risk       = $invoice->war_risk_charge;
    $calc_ddp            = $invoice->ddp;
    $calc_grand          = $invoice->grand_total;

    $isAdmin = in_array(auth()->user()->role ?? '', ['admin', 'dev', 'owner']);
    $ddpPercent = Setting::get('ddp_percent', 19);

    return view('invoice.detail', compact(
        'invoice', 'shipments', 'items',
        'shipper_name', 'shipper_email', 'shipper_phone', 'shipper_company',
        'total_berat', 'total_usd', 'calc_subtotal', 'calc_war_risk', 'calc_ddp', 'calc_grand',
        'isAdmin','ddpPercent'
    ));
}

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

    public function markAsPaid($hashid)
    {
        $id = hashid_decode($hashid);
        if (!$id) abort(404);

        $invoice = Invoice::findOrFail($id);
        $invoice->status = 'Paid';
        $invoice->save();

        return redirect()->back()->with('success', 'Invoice ditandai sebagai Lunas.');
    }

    public function destroy($hashid)
    {
        $id = hashid_decode($hashid);
        if (!$id) abort(404);

        $invoice = Invoice::findOrFail($id);
        // Hapus items terlebih dahulu
        $invoice->items()->delete();
        $invoice->delete();

        return redirect()->route('admin.invoices.index')->with('success', 'Invoice berhasil dihapus.');
    }

    private function generateInvoiceNumber()
    {
        $last = Invoice::latest()->first();
        $number = $last ? intval(substr($last->nomor_inv, -4)) + 1 : 1;
        return 'INV-' . date('ymd') . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}