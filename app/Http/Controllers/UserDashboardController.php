<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\LogsActivity;
use Illuminate\Support\Facades\DB;

class UserDashboardController extends Controller
{
    use LogsActivity;
    
    public function __construct()
    {
        // Pastikan user login untuk semua method di controller ini
        $this->middleware('auth');
    }

    /**
     * Dashboard utama user (ringkasan + riwayat pengiriman)
     */
    public function index()
    {
        $user = Auth::user();

        // Statistik
        $totalShipments = DB::table('shipments')
            ->where('user_id', $user->id)
            ->where('status_pengerjaan', '!=', 'Cancelled')
            ->count();

        $totalSpent = DB::table('shipments')
            ->where('user_id', $user->id)
            ->where('status_pengerjaan', '!=', 'Cancelled')
            ->sum('charge_idr');

        // Daftar pengiriman dengan pagination
        $shipments = DB::table('shipments')
            ->where('user_id', $user->id)
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('user.dashboard', compact('user', 'totalShipments', 'totalSpent', 'shipments'));
    }

    /**
     * Hapus shipment (hanya jika status Pending)
     */
    public function destroyShipment($id)
    {
        $user = Auth::user();

        $shipment = DB::table('shipments')
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$shipment) {
            return response()->json(['success' => false, 'message' => 'Pengiriman tidak ditemukan.'], 404);
        }

        if (strtolower($shipment->status_pengerjaan ?? '') !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Hanya pengiriman dengan status Pending yang dapat dihapus.'], 403);
        }

        DB::table('shipments')->where('id', $id)->delete();

        return response()->json(['success' => true, 'message' => 'Pengiriman berhasil dihapus.']);
    }

    /**
     * Daftar invoice milik user yang login
     */
    // Di app/Http/Controllers/UserDashboardController.php

public function invoices(Request $request)
{
    $user = Auth::user();
    $userEmail = $user->email;
    $userName  = $user->name;

    $status = $request->get('status', 'all');
    $search = trim($request->get('search', ''));
    $page   = max(1, (int)$request->get('page', 1));
    $limit  = 15;
    $offset = ($page - 1) * $limit;

    // ✅ Gunakan where dengan closure untuk menggabungkan email OR nama
    $query = DB::table('invoices')
        ->where(function ($q) use ($userEmail, $userName) {
            $q->where('email_customer', $userEmail)
              ->orWhere('nama_customer', $userName);
        });

    if ($status !== 'all') {
        $query->where('status', $status);
    }
    if ($search !== '') {
        $query->where('nomor_inv', 'LIKE', "%{$search}%");
    }

    $totalRows   = $query->count();
    $totalPages  = ceil($totalRows / $limit);
    $invoices    = $query->orderBy('id', 'desc')->offset($offset)->limit($limit)->get();

    // Tambahkan jumlah paket
    foreach ($invoices as $inv) {
        $inv->jumlah_paket = DB::table('invoice_items')
            ->where('invoice_id', $inv->id)
            ->count();
    }

    // Statistik
    $stats = DB::table('invoices')
        ->where(function ($q) use ($userEmail, $userName) {
            $q->where('email_customer', $userEmail)
              ->orWhere('nama_customer', $userName);
        })
        ->selectRaw('
            COUNT(*) as total,
            SUM(grand_total) as total_nilai,
            SUM(CASE WHEN status = "Unpaid" THEN 1 ELSE 0 END) as total_unpaid,
            SUM(CASE WHEN status = "Unpaid" THEN grand_total ELSE 0 END) as nilai_unpaid,
            SUM(CASE WHEN status = "Paid" THEN grand_total ELSE 0 END) as nilai_paid
        ')
        ->first();

    return view('user.invoices', compact(
        'user', 'invoices', 'stats', 'status', 'search',
        'page', 'totalPages', 'totalRows'
    ));
}

public function showInvoice($hashid)
{
    $id = hashid_decode($hashid);
    if (!$id) abort(404);
    
    $user = Auth::user();
    $invoice = DB::table('invoices')
        ->where('id', $id)
        ->where(function ($q) use ($user) {
            $q->where('email_customer', $user->email)
              ->orWhere('nama_customer', $user->name);
        })
        ->first();
    
    if (!$invoice) abort(404);

    // Ambil semua shipment_id dari invoice_items
    $shipmentIds = DB::table('invoice_items')
        ->where('invoice_id', $invoice->id)
        ->pluck('shipment_id');

    // Ambil data shipments berdasarkan id yang sudah didapat
    $shipments = DB::table('shipments')
        ->select([
            'tracking_number',
            'nama_penerima',
            'negara',
            'service',
            'charge_idr as ongkir',
            'panjang',
            'lebar',
            'tinggi',
            'berat_dibebankan',
            'declare_value_usd',
            'content',
            'alamat_penerima'
        ])
        ->whereIn('id', $shipmentIds)
        ->get();

    // Tambahkan phone_customer (fallback dari user yang login)
    foreach ($shipments as $ship) {
        $ship->phone_customer = $user->phone ?? '-';
    }

    // Buat alias $items = $shipments agar view tetap berfungsi
    $items = $shipments;

    return view('user.invoice_detail', compact('invoice', 'items', 'shipments'));
}

public function publicInvoice($hashid, Request $request)
{
    $id = hashid_decode($hashid);
    if (!$id) abort(404);
    
    $invoice = DB::table('invoices')->where('id', $id)->first();
    if (!$invoice) abort(404);
    
    // Tampilkan view invoice sederhana (tanpa sidebar/login)
    return view('user.public_invoice', compact('invoice'));
}

}