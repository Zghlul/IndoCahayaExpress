<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\User;
use App\Models\Shipment;
use App\Traits\LogsActivity;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Cache;
use App\Models\Setting;
use App\Services\ExchangeRateService;

class AdminController extends Controller
{
    use LogsActivity;
    
    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $role = Auth::user()->role ?? '';
        if (!in_array($role, ['admin', 'owner', 'dev'])) {
            return redirect()->route('home')->with('error', 'Unauthorized access');
        }

        $totalOrders = DB::table('shipments')->where('status_pengerjaan', '!=', 'Cancelled')->count();
        $totalIncome = DB::table('shipments')->where('status_pengerjaan', '!=', 'Cancelled')->sum('charge_idr');
        $totalUsers  = DB::table('users')->count();
        $recentShipments = DB::table('shipments')->orderBy('id', 'desc')->limit(5)->get();

        return view('admin.dashboard', compact('totalOrders', 'totalIncome', 'totalUsers', 'recentShipments'));
    }

    public function activityLogs()
    {
        $logs = ActivityLog::with('user')->latest()->paginate(50);
        return view('admin.activity_logs', compact('logs'));
    }

    public function orders()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $role = Auth::user()->role ?? '';
        if (!in_array($role, ['admin', 'owner', 'dev'])) {
            return redirect()->route('home')->with('error', 'Unauthorized access');
        }

        $shipments = DB::table('shipments')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.orders', compact('shipments'));
    }

    public function invoices(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $role = Auth::user()->role ?? '';
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

    public function members(Request $request)
    {
        $role = auth()->user()->role ?? '';
        if (!in_array($role, ['admin', 'owner', 'dev'])) {
            return redirect()->route('home')->with('error', 'Unauthorized access');
        }

        $search = $request->get('q', '');
        $filter_role = $request->get('role', '');

        $query = User::query();
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }
        if ($filter_role) {
            $query->where('role', $filter_role);
        }

        $users = $query->orderBy('id', 'desc')->paginate(15);
        $users->appends($request->query());

        $stats = [
            'total' => User::count(),
            'admins' => User::where('role', 'admin')->count(),
            'devs' => User::where('role', 'dev')->count(),
            'users_count' => User::where('role', 'user')->count(),
        ];

        $editUser = null;
        $showForm = false;
        if ($request->has('edit')) {
            $editUser = User::find($request->edit);
            if ($editUser) $showForm = true;
        }
        if ($request->get('action') === 'add') {
            $showForm = true;
        }

        return view('d-e-v.members', compact('users', 'stats', 'editUser', 'showForm'));
    }

    public function saveMember(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $request->edit_id,
            'password' => $request->edit_id ? 'nullable|min:6' : 'required|min:6',
            'role' => 'required|in:user,admin,dev,owner',
        ]);

        if ($request->edit_id) {
            $user = User::findOrFail($request->edit_id);
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->role = $request->role;
            $user->save();
            return redirect()->route('d-e-v.members')->with('flash_members', 'Member berhasil diupdate!');
        } else {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);
            return redirect()->route('d-e-v.members')->with('flash_members', 'Member baru berhasil ditambahkan!');
        }
    }

    public function deleteMember($id)
    {
        if ($id == auth()->id()) {
            return redirect()->route('d-e-v.members')->with('flash_members_err', 'Tidak dapat menghapus akun sendiri.');
        }
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('d-e-v.members')->with('flash_members', 'Member berhasil dihapus.');
    }

    public function bulkDeleteMembers(Request $request)
    {
        $ids = $request->input('selected_ids', []);
        $myId = auth()->id();
        $ids = array_filter($ids, fn($id) => $id != $myId);
        if (!empty($ids)) {
            User::whereIn('id', $ids)->delete();
            return redirect()->route('d-e-v.members')->with('flash_members', count($ids) . ' member berhasil dihapus.');
        }
        return redirect()->route('d-e-v.members')->with('flash_members_err', 'Tidak ada data dipilih atau tidak bisa hapus sendiri.');
    }

    public function rates(Request $request)
    {
        $role = auth()->user()->role ?? '';
        if (!in_array($role, ['admin', 'owner', 'dev'])) {
            return redirect()->route('home')->with('error', 'Unauthorized');
        }

        $vendorTables = [
            'PRIORITY'      => 'dhl_rate',
            'fedex'    => 'fedex_rate',
            'REGULER' => 'singpost_rate',
            'US REGULER'     => 'usps_rate',
            'FAST ASIAN'     => 'tlx_rate',
            'FLASH'     => 'aramex_rate',
            'FLASH AUSSY'     => 'tge_rate',
        ];

        $search = trim($request->get('search', ''));

        $vendorRates = [];
        $vendorCounts = [];
        foreach ($vendorTables as $vendor => $table) {
            $vendorCounts[$vendor] = DB::table($table)->count();

            $query = DB::table($table . ' as r')
                ->join('countries as c1', 'r.origin_country_id', '=', 'c1.id')
                ->join('countries as c2', 'r.destination_country_id', '=', 'c2.id')
                ->select('r.*', 'c1.country_name as origin_country', 'c2.country_name as destination_country');
            if ($search) {
                $query->where('c2.country_name', 'LIKE', "%$search%");
            }
            $vendorRates[$vendor] = $query->orderBy('c2.country_name')->orderBy('r.weight_kg')->limit(100)->get();
        }

        $countries = DB::table('countries')
            ->where('country_name', '!=', 'Indonesia')
            ->orderBy('country_name')
            ->get();
        $totalCountries = $countries->count();
        $totalAllRates = array_sum($vendorCounts);

        return view('admin.rates', compact(
            'vendorRates', 'vendorCounts', 'countries', 'totalCountries', 'totalAllRates', 'search'
        ));
    }

    public function updateRate(Request $request)
    {
        $vendor = $request->input('vendor');
        $rateId = $request->input('rate_id');
        $price  = (float) $request->input('price');
        $modal  = (float) $request->input('modal');
        $weight = (float) $request->input('weight_kg');

        $tableMap = [
            'PRIORITY'      => 'dhl_rate',
            'fedex'    => 'fedex_rate',
            'REGULER' => 'singpost_rate',
            'US REGULER'     => 'usps_rate',
            'FAST ASIAN'     => 'tlx_rate',
            'FLASH'     => 'aramex_rate',
            'FLASH AUSSY'     => 'tge_rate',
        ];

        if (isset($tableMap[$vendor]) && $rateId) {
            DB::table($tableMap[$vendor])->where('id', $rateId)->update([
                'price'     => $price,
                'modal'     => $modal,
                'weight_kg' => $weight,
            ]);
        }

        return redirect()->route('admin.rates')->with('success', 'Rate berhasil diperbarui.');
    }

    public function addCountry(Request $request)
    {
        $role = auth()->user()->role ?? '';
        if ($role !== 'dev') {
            return redirect()->route('admin.rates')->with('error', 'Hanya developer yang dapat menambah negara.');
        }
        $name = trim($request->input('country_name'));
        if ($name && !DB::table('countries')->where('country_name', $name)->exists()) {
            DB::table('countries')->insert(['country_name' => $name]);
        }
        return redirect()->route('admin.rates')->with('success', 'Negara berhasil ditambahkan.');
    }

    public function updateCountry(Request $request)
    {
        $role = auth()->user()->role ?? '';
        if ($role !== 'dev') {
            return redirect()->route('admin.rates')->with('error', 'Unauthorized');
        }
        $id = (int) $request->input('country_id');
        $name = trim($request->input('country_name'));
        if ($id && $name) {
            DB::table('countries')->where('id', $id)->update(['country_name' => $name]);
        }
        return redirect()->route('admin.rates')->with('success', 'Negara berhasil diperbarui.');
    }

    public function deleteCountry(Request $request)
    {
        $role = auth()->user()->role ?? '';
        if ($role !== 'dev') {
            return redirect()->route('admin.rates')->with('error', 'Unauthorized');
        }
        $id = (int) $request->input('country_id');
        if ($id) {
            $tables = ['dhl_rate', 'fedex_rate', 'singpost_rate', 'usps_rate', 'tlx_rate', 'aramex_rate', 'tge_rate'];
            foreach ($tables as $table) {
                DB::table($table)->where('destination_country_id', $id)->delete();
                DB::table($table)->where('origin_country_id', $id)->delete();
            }
            DB::table('countries')->where('id', $id)->delete();
        }
        return redirect()->route('admin.rates')->with('success', 'Negara dan rates terkait dihapus.');
    }

    public function resetRates()
    {
        $role = auth()->user()->role ?? '';
        if ($role !== 'dev') {
            return redirect()->route('admin.rates')->with('error', 'Hanya developer yang dapat mereset rates.');
        }

        DB::table('dhl_rate')->truncate();
        DB::table('fedex_rate')->truncate();
        DB::table('singpost_rate')->truncate();
        DB::table('usps_rate')->truncate();
        DB::table('tlx_rate')->truncate();
        DB::table('aramex_rate')->truncate();
        DB::table('tge_rate')->truncate();

        return redirect()->route('admin.rates')->with('success', 'Semua rates berhasil direset.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('selected_ids', []);
        if (!empty($ids)) {
            DB::table('shipments')->whereIn('id', $ids)->delete();
            return redirect()->back()->with('flash_success', count($ids) . ' data pengiriman berhasil dihapus.');
        }
        return redirect()->back()->with('error', 'Tidak ada data dipilih.');
    }

    public function markInvoicePaid(Request $request, $id)
    {
        $id = hashid_decode($id);
        if (!$id) abort(404);
    
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

    public function deleteInvoice($hashid)
    {
        $id = hashid_decode($hashid);
        if (!$id) abort(404);

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

    public function ranking()
    {
        $role = auth()->user()->role ?? '';
        if (!in_array($role, ['admin', 'owner', 'dev'])) {
            return redirect()->route('home')->with('error', 'Unauthorized access');
        }

        $rankingData = DB::table('users as u')
            ->select(
                'u.id',
                'u.name',
                'u.email',
                'u.company_name',
                DB::raw('COUNT(s.id) as total_delivered'),
                DB::raw('SUM(s.charge_idr) as total_spent')
            )
            ->join('shipments as s', 'u.id', '=', 's.user_id')
            ->whereRaw('LOWER(s.status_pengerjaan) = ?', ['delivered'])
            ->groupBy('u.id', 'u.name', 'u.email', 'u.company_name')
            ->orderBy('total_delivered', 'DESC')
            ->orderBy('total_spent', 'DESC')
            ->limit(20)
            ->get();

        $totalCustomers = DB::table('shipments')
            ->whereRaw('LOWER(status_pengerjaan) = ?', ['delivered'])
            ->distinct('user_id')
            ->count('user_id');

        $totalShipmentsDelivered = DB::table('shipments')
            ->whereRaw('LOWER(status_pengerjaan) = ?', ['delivered'])
            ->count();

        $totalRevenue = DB::table('shipments')
            ->whereRaw('LOWER(status_pengerjaan) = ?', ['delivered'])
            ->sum('charge_idr');

        return view('admin.ranking', compact('rankingData', 'totalCustomers', 'totalShipmentsDelivered', 'totalRevenue'));
    }

    public function reports(Request $request)
{
    $role = auth()->user()->role ?? '';
    if (!in_array($role, ['admin', 'owner', 'dev'])) {
        return redirect()->route('home')->with('error', 'Unauthorized access');
    }

    // Ambil parameter filter
    $filterType = $request->get('filter_type', '');
    $year = (int) $request->get('year', date('Y'));
    $month = (int) $request->get('month', date('n'));
    $date = $request->get('date', '');
    $week = (int) $request->get('week', 0);

    if (!empty($filterType) && $year == 0) $year = date('Y');

    // Period label
    $periodType = '';
    $periodName = 'Semua Periode';
    if ($filterType === 'daily') {
        $periodType = 'HARIAN';
        $periodName = $date ? date('d F Y', strtotime($date)) : '-';
    } elseif ($filterType === 'weekly') {
        $periodType = 'MINGGUAN';
        $periodName = "Minggu ke-$week Tahun $year";
    } elseif ($filterType === 'monthly') {
        $periodType = 'BULANAN';
        $periodName = date('F Y', mktime(0,0,0,$month,1,$year));
    } elseif ($filterType === 'yearly') {
        $periodType = 'TAHUNAN';
        $periodName = "Tahun $year";
    } else {
        $periodType = 'ALL';
    }

    // Build date filter clause
    $dateFilter = '';
    if ($filterType === 'daily' && $date) {
        $dateFilter = "DATE(created_at) = '$date'";
    } elseif ($filterType === 'weekly' && $week > 0) {
        $dateFilter = "YEAR(created_at) = $year AND WEEK(created_at, 1) = $week";
    } elseif ($filterType === 'monthly' && $month > 0) {
        $dateFilter = "DATE_FORMAT(created_at,'%Y-%m') = '$year-" . str_pad($month,2,'0',STR_PAD_LEFT) . "'";
    } elseif ($filterType === 'yearly' && $year > 0) {
        $dateFilter = "YEAR(created_at) = $year";
    }

    // Date format for grouping
    if ($filterType === 'daily') {
        $dateFormat = '%Y-%m-%d %H';
        $groupBy = "DATE_FORMAT(created_at,'%Y-%m-%d %H')";
    } elseif (in_array($filterType, ['weekly', 'monthly'])) {
        $dateFormat = '%Y-%m-%d';
        $groupBy = "DATE_FORMAT(created_at,'%Y-%m-%d')";
    } elseif ($filterType === 'yearly') {
        $dateFormat = '%Y-%m';
        $groupBy = "DATE_FORMAT(created_at,'%Y-%m')";
    } else {
        $dateFormat = '%Y-%m';
        $groupBy = "DATE_FORMAT(created_at,'%Y-%m')";
    }

    // Query aggregated data
    $query = DB::table('shipments as s')
        ->select(DB::raw("DATE_FORMAT(s.created_at, '$dateFormat') AS period"),
                 DB::raw('COUNT(*) AS total'),
                 DB::raw('SUM(s.charge_idr) AS income'),
                 DB::raw('0 AS modal'),
                 DB::raw('SUM(s.charge_idr) AS profit'))
        ->where('s.status_pengerjaan', '!=', 'Cancelled');
    if ($dateFilter) {
        $query->whereRaw($dateFilter);
    }
    $rows = $query->groupBy(DB::raw($groupBy))
                  ->orderBy('period', 'DESC')
                  ->get();

    // Totals
    $totalOrders = $rows->sum('total');
    $totalIncome = $rows->sum('income');
    $totalProfit = $rows->sum('profit');

    // Expenses (gunakan dummy jika tabel expenses belum ada)
    $hasExpenses = Schema::hasTable('expenses');
    $expenses = ['gaji' => 0, 'operasional' => 0, 'marketing' => 0, 'admin' => 0, 'lainnya' => 0];
    if ($hasExpenses) {
        $expQuery = DB::table('expenses');
        if ($filterType === 'monthly' && $year > 0 && $month > 0) {
            $expQuery->whereMonth('expense_date', $month)->whereYear('expense_date', $year);
        } elseif ($filterType === 'yearly' && $year > 0) {
            $expQuery->whereYear('expense_date', $year);
        }
        $expCategories = $expQuery->select('category', DB::raw('SUM(amount) as total'))->groupBy('category')->get();
        foreach ($expCategories as $e) {
            if (array_key_exists($e->category, $expenses)) {
                $expenses[$e->category] = $e->total;
            }
        }
    } else {
        $expenses = ['gaji' => 15000000, 'operasional' => 5000000, 'marketing' => 3000000, 'admin' => 2000000, 'lainnya' => 0];
        if ($filterType === 'yearly') {
            foreach ($expenses as $key => $val) {
                $expenses[$key] = $val * 12;
            }
        }
    }

    $totalBiaya = array_sum($expenses);
    $netProfit = $totalProfit - $totalBiaya;

    // Chart data: daily for current month, monthly for current year
    $currentYear = date('Y');
    $currentMonth = date('n');
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
    $dailyData = [];
    $maxDailyRev = 0;
    for ($d = 1; $d <= $daysInMonth; $d++) {
        $dateStr = date('Y-m-d', mktime(0,0,0,$currentMonth,$d,$currentYear));
        $rev = DB::table('shipments')
            ->whereDate('created_at', $dateStr)
            ->where('status_pengerjaan', '!=', 'Cancelled')
            ->sum('charge_idr');
        $ord = DB::table('shipments')
            ->whereDate('created_at', $dateStr)
            ->where('status_pengerjaan', '!=', 'Cancelled')
            ->count();
        $dailyData[] = [
            'rev' => $rev,
            'ord' => $ord,
            'lbl' => $d,
            'title' => date('d M', strtotime($dateStr))
        ];
        $maxDailyRev = max($maxDailyRev, $rev);
    }
    $currentMonthRev = DB::table('shipments')
        ->whereMonth('created_at', $currentMonth)
        ->whereYear('created_at', $currentYear)
        ->where('status_pengerjaan', '!=', 'Cancelled')
        ->sum('charge_idr');
    $currentMonthOrd = DB::table('shipments')
        ->whereMonth('created_at', $currentMonth)
        ->whereYear('created_at', $currentYear)
        ->where('status_pengerjaan', '!=', 'Cancelled')
        ->count();

    // Yearly monthly chart
    $monthNames = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'];
    $monthlyData = [];
    $maxMonthlyRev = 0;
    for ($m = 1; $m <= 12; $m++) {
        $rev = DB::table('shipments')
            ->whereMonth('created_at', $m)
            ->whereYear('created_at', $currentYear)
            ->where('status_pengerjaan', '!=', 'Cancelled')
            ->sum('charge_idr');
        $ord = DB::table('shipments')
            ->whereMonth('created_at', $m)
            ->whereYear('created_at', $currentYear)
            ->where('status_pengerjaan', '!=', 'Cancelled')
            ->count();
        $monthlyData[] = [
            'rev' => $rev,
            'ord' => $ord,
            'lbl' => $monthNames[$m-1]
        ];
        $maxMonthlyRev = max($maxMonthlyRev, $rev);
    }
    $currentYearRev = DB::table('shipments')
        ->whereYear('created_at', $currentYear)
        ->where('status_pengerjaan', '!=', 'Cancelled')
        ->sum('charge_idr');
    $currentYearOrd = DB::table('shipments')
        ->whereYear('created_at', $currentYear)
        ->where('status_pengerjaan', '!=', 'Cancelled')
        ->count();

    return view('admin.reports', compact(
        'filterType', 'year', 'month', 'date', 'week',
        'periodType', 'periodName',
        'totalOrders', 'totalIncome', 'totalProfit', 'netProfit',
        'expenses', 'totalBiaya',
        'rows',
        'dailyData', 'maxDailyRev', 'daysInMonth', 'currentMonthRev', 'currentMonthOrd',
        'monthlyData', 'maxMonthlyRev', 'currentYearRev', 'currentYearOrd',
        'monthNames', 'currentYear', 'currentMonth'
    ));
}

public function expenses(Request $request)
{
    $role = auth()->user()->role ?? '';
    if (!in_array($role, ['dev', 'owner'])) {
        return redirect()->route('home')->with('error', 'Unauthorized access');
    }

    // Handle delete via GET (dari tombol hapus)
    if ($request->has('delete')) {
        $id = (int) $request->delete;
        DB::table('expenses')->where('id', $id)->delete();
        return redirect()->route('admin.expenses')->with('success', 'Pengeluaran berhasil dihapus.');
    }

    // Data untuk form edit
    $editExpense = null;
    if ($request->has('edit')) {
        $editExpense = DB::table('expenses')->where('id', (int) $request->edit)->first();
    }

    // Filter
    $filterMonth = $request->get('month', date('m'));
    $filterYear  = $request->get('year', date('Y'));
    $filterCategory = $request->get('category', '');

    $query = DB::table('expenses');
    if ($filterMonth) $query->whereMonth('expense_date', $filterMonth);
    if ($filterYear)  $query->whereYear('expense_date', $filterYear);
    if ($filterCategory) $query->where('category', $filterCategory);
    $expenses = $query->orderBy('expense_date', 'DESC')->get();

    // Hitung total per kategori
    $totalPerCategory = [
        'gaji'        => $expenses->where('category', 'gaji')->sum('amount'),
        'operasional' => $expenses->where('category', 'operasional')->sum('amount'),
        'marketing'   => $expenses->where('category', 'marketing')->sum('amount'),
        'admin'       => $expenses->where('category', 'admin')->sum('amount'),
        'lainnya'     => $expenses->where('category', 'lainnya')->sum('amount'),
    ];
    $totalExpenses = $expenses->sum('amount');

    // Daftar kategori untuk dropdown filter
    $categories = DB::table('expenses')->select('category')->distinct()->pluck('category');

    return view('admin.expenses', compact(
        'expenses', 'totalExpenses', 'totalPerCategory', 'categories',
        'filterMonth', 'filterYear', 'filterCategory', 'editExpense'
    ));
}

/**
 * Simpan (tambah/edit) pengeluaran
 */
public function saveExpense(Request $request)
{
    $role = auth()->user()->role ?? '';
    if (!in_array($role, ['dev', 'owner'])) {
        return redirect()->back()->with('error', 'Unauthorized');
    }

    $data = $request->validate([
        'category' => 'required|string',
        'description' => 'required|string',
        'amount' => 'required|numeric|min:0',
        'expense_date' => 'required|date',
        'edit_id' => 'nullable|integer'
    ]);

    if ($data['edit_id'] > 0) {
        DB::table('expenses')->where('id', $data['edit_id'])->update([
            'category' => $data['category'],
            'description' => $data['description'],
            'amount' => $data['amount'],
            'expense_date' => $data['expense_date'],
        ]);
        return redirect()->route('admin.expenses')->with('success', 'Pengeluaran berhasil diupdate!');
    } else {
        DB::table('expenses')->insert([
            'category' => $data['category'],
            'description' => $data['description'],
            'amount' => $data['amount'],
            'expense_date' => $data['expense_date'],
            'created_by' => auth()->id(),
            'created_at' => now(),
        ]);
        return redirect()->route('admin.expenses')->with('success', 'Pengeluaran baru berhasil ditambahkan!');
    }
}

/**
 * Hapus pengeluaran (alternatif via POST, tapi kita pakai GET di view)
 */
public function deleteExpense($id)
{
    $role = auth()->user()->role ?? '';
    if (!in_array($role, ['dev', 'owner'])) {
        return redirect()->back()->with('error', 'Unauthorized');
    }
    DB::table('expenses')->where('id', $id)->delete();
    return redirect()->route('admin.expenses')->with('success', 'Pengeluaran berhasil dihapus.');
}

/**
 * Export Excel (sementara)
 */
public function exportExpenses(Request $request)
{
    // Implementasi export nanti, untuk sementara redirect
    return redirect()->route('admin.expenses')->with('info', 'Fitur export sedang dalam pengembangan.');
}

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

    // 🔧 Ambil persen DDP dari database
    $ddpPercent = Setting::get('ddp_percent', 19);

    $customers = DB::table('users as u')
        ->select('u.id', 'u.name', 'u.email', 'u.phone', 'u.company_name')
        ->whereIn(DB::raw('u.name COLLATE utf8mb4_unicode_ci'), function($q) {
            $q->select(DB::raw('DISTINCT nama_customer COLLATE utf8mb4_unicode_ci'))
              ->from('shipments')
              ->where('status_pengerjaan', 'Pending')
              ->whereNotIn('id', function($sub) {
                  $sub->select(DB::raw('CAST(ii.shipment_id AS UNSIGNED)'))
                      ->from('invoice_items as ii')
                      ->whereNotNull('ii.shipment_id');
              });
        })
        ->orderBy('u.name')
        ->get();

    return view('admin.create_invoice', compact('customers', 'preSelectedShipment', 'usdRate', 'ddpPercent'));
}

    // Method storeInvoice – perbaiki perhitungan DDP
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

    // 🔧 Hitung DDP hanya untuk shipment ke US/Canada dengan kurs real-time dan persen dari setting
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
        $ddpPercent = Setting::get('ddp_percent', 19); // ambil dari database
        $ddp = round($totalDeclareUSD * $usdRate * ($ddpPercent / 100), 2);
    }

    $grandTotal = $subtotal + $ddp;

    $date   = date('ymd');
    $random = strtoupper(substr(uniqid(), -4));
    $nomorInv = "INV/{$date}/{$random}";

    DB::beginTransaction();
    try {
        $invoiceId = DB::table('invoices')->insertGetId([
            'nomor_inv'      => $nomorInv,
            'nama_customer'  => $customerName,
            'email_customer' => $customerEmail,
            'subtotal'       => $subtotal,
            'ddp'            => $ddp,
            'war_risk_charge'=> 0, // sementara
            'aramex_surcharge'=> 0, // sementara
            'grand_total'    => $grandTotal,
            'status'         => 'Unpaid',
            'created_by'     => auth()->id(),
            'created_at'     => now(),
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

    public function ajaxShipmentsByCustomer(Request $request)
    {
        $userId = $request->get('user_id');
        if (!$userId) {
            return response()->json([]);
        }
        $shipments = DB::table('shipments')
            ->where('user_id', $userId)
            ->where('status_pengerjaan', 'Pending')
            ->whereNotIn('id', function($q) {
                $q->select(DB::raw('CAST(shipment_id AS UNSIGNED)'))
                  ->from('invoice_items')
                  ->whereNotNull('shipment_id');
            })
            ->select('id', 'tracking_number', 'nama_penerima', 'negara', 'service', 'berat_dibebankan', 'charge_idr', 'content', 'declare_value_usd')
            ->get();
        return response()->json($shipments);
    }

    /**
     * Tampilkan detail invoice - redirect ke route baru
     */
    public function showInvoice($hashid)
    {
        return redirect()->route('invoice.detail', $hashid);
    }

    public function editMember($id)
    {
        $user = User::findOrFail($id);
        return redirect()->route('d-e-v.members', ['edit' => $user->id]);
    }

    public function editInvoice($hashid)
    {
        $id = hashid_decode($hashid);
        if (!$id) abort(404);
        
        $invoice = Invoice::findOrFail($id);
        $items = InvoiceItem::where('invoice_id', $id)->get();
        $shipmentIds = $items->pluck('shipment_id')->toArray();
        $shipments = DB::table('shipments')->whereIn('id', $shipmentIds)->get();
        $customers = DB::table('users')->orderBy('name')->get();
        
        return view('admin.edit_invoice', compact('invoice', 'items', 'shipments', 'customers'));
    }

    /**
     * Update invoice via AJAX - DIPERBAIKI
     */
    public function updateInvoice(Request $request, $id)
{
    $id = hashid_decode($id);
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
        // ddp dan grand_total tidak divalidasi karena readonly
    ]);

    $invoice = Invoice::findOrFail($id);
    $invoice->nama_customer = $request->nama_customer;
    $invoice->email_customer = $request->email_customer;
    $invoice->status = $request->status;

    // Simpan subtotal baru
    $newSubtotal = (float) $request->subtotal;
    $oldSubtotal = (float) $invoice->subtotal;
    $invoice->subtotal = $newSubtotal;
    
    // DDP tidak berubah (tetap nilai lama)
    $ddp = (float) $invoice->ddp;
    $invoice->grand_total = $newSubtotal + $ddp;
    $invoice->save();

    // Jika subtotal berubah, distribusikan ke shipment items secara proporsional
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

public function settings()
{
    // Ambil semua setting dari database dalam bentuk array key => value
    $settings = Setting::all()->pluck('value', 'key')->toArray();
    
    return view('d-e-v.settings', compact('settings'));
}

public function toggleMaintenance(Request $request)
{
    \Log::info('toggleMaintenance dipanggil', ['user' => auth()->id(), 'ajax' => $request->ajax()]);

    $current = Setting::get('maintenance_mode', '0');
    $new = $current == '1' ? '0' : '1';
    Setting::set('maintenance_mode', $new);
    Cache::forget('global_settings');

    return response()->json(['success' => true, 'mode' => $new]);
}

    public function saveSettings(Request $request)
{
    $action = $request->input('action');
    $groups = [
        'save_general'  => ['site_name','site_tagline','site_email','site_phone','site_address','maintenance_mode'],
        'save_smtp'     => ['smtp_host','smtp_port','smtp_user','smtp_pass','smtp_encryption','mail_from_name','mail_from_email'],
        'save_shipping' => ['default_currency','weight_unit','dimension_unit','max_weight','war_risk_percent','ddp_percent'],
        'save_security' => ['session_lifetime','max_login_attempts','lockout_duration','require_email_verify','two_factor_admin'],
        'save_api'      => ['google_maps_key','recaptcha_site_key','recaptcha_secret_key','whatsapp_api_token','whatsapp_number','exchange_rate_api_url'],
    ];

    if (isset($groups[$action])) {
        // Simpan setting
        foreach ($groups[$action] as $key) {
            $value = $request->input($key, '');
            DB::table('system_settings')->updateOrInsert(
                ['key' => $key],
                ['value' => $value]
            );
        }
        
        // 🔧 Jika action adalah shipping dan ddp_percent ikut diubah, recalculate invoice
        if ($action === 'save_shipping' && $request->has('ddp_percent')) {
            $count = Invoice::recalculateAllDDP(true); // hanya unpaid
            \Log::info("DDP percent changed to {$request->ddp_percent}%, recalculated {$count} invoices.");
        }
        
        Cache::forget('global_settings');
        return back()->with('success', 'Pengaturan berhasil disimpan. ' . ($count ?? 0) . ' invoice diperbarui.');
    }

    return back()->with('error', 'Aksi tidak valid.');
}

    public function clearCache(Request $request)
    {
        $cachePath = storage_path('framework/cache');
        if (is_dir($cachePath)) {
            $files = glob($cachePath . '/*');
            foreach ($files as $file) {
                if (is_file($file)) @unlink($file);
            }
        }
        return back()->with('success', 'Cache berhasil dibersihkan.');
    }

    public function resetSettings(Request $request)
{
    DB::table('system_settings')->truncate();
    $defaults = [
        // General
        ['key' => 'site_name', 'value' => 'Indo Cahaya Express'],
        ['key' => 'site_tagline', 'value' => 'Fast & Reliable'],
        ['key' => 'site_email', 'value' => 'indocahayaexpress@gmail.com'],
        ['key' => 'site_phone', 'value' => '+62 812 3456 7890'],
        ['key' => 'site_address', 'value' => 'Perum. Citra Indah Bukit Amarilis Blok AR 00 no. 010'],
        ['key' => 'maintenance_mode', 'value' => '0'],
        
        // SMTP
        ['key' => 'smtp_host', 'value' => ''],
        ['key' => 'smtp_port', 'value' => '587'],
        ['key' => 'smtp_user', 'value' => ''],
        ['key' => 'smtp_pass', 'value' => ''],
        ['key' => 'smtp_encryption', 'value' => 'tls'],
        ['key' => 'mail_from_name', 'value' => ''],
        ['key' => 'mail_from_email', 'value' => ''],
        
        // Shipping
        ['key' => 'default_currency', 'value' => 'IDR'],
        ['key' => 'weight_unit', 'value' => 'kg'],
        ['key' => 'dimension_unit', 'value' => 'cm'],
        ['key' => 'max_weight', 'value' => '70'],
        ['key' => 'insurance_rate', 'value' => '0.5'],
        ['key' => 'fuel_surcharge', 'value' => '5'],
        ['key' => 'war_risk_percent', 'value' => '32'],
        ['key' => 'ddp_percent', 'value' => '19'],
        
        // Security
        ['key' => 'session_lifetime', 'value' => '120'],
        ['key' => 'max_login_attempts', 'value' => '5'],
        ['key' => 'lockout_duration', 'value' => '30'],
        ['key' => 'require_email_verify', 'value' => '0'],
        ['key' => 'two_factor_admin', 'value' => '0'],
        
        // API
        ['key' => 'google_maps_key', 'value' => ''],
        ['key' => 'recaptcha_site_key', 'value' => ''],
        ['key' => 'recaptcha_secret_key', 'value' => ''],
        ['key' => 'whatsapp_api_token', 'value' => ''],
        ['key' => 'whatsapp_number', 'value' => ''],
        ['key' => 'exchange_rate_api_url', 'value' => 'https://api.exchangerate-api.com/v4/latest/USD'],
    ];
    
    foreach ($defaults as $default) {
        DB::table('system_settings')->insert($default);
    }
    
    // Hapus cache global settings
    \Illuminate\Support\Facades\Cache::forget('global_settings');
    
    return back()->with('success', 'Semua pengaturan direset ke default.');
}
}