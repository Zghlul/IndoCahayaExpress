<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;
use App\Services\ExchangeRateService;

class ReportController extends Controller
{
    /**
     * Halaman utama laporan keuangan.
     */
    public function reports(Request $request)
    {
        $role = auth()->user()->role ?? '';
        if (!in_array($role, ['admin', 'owner', 'dev'])) {
            return redirect()->route('home')->with('error', 'Unauthorized access');
        }

        // Ambil data rows dari method helper
        $rows = $this->getReportRows($request);

        // Ambil parameter filter untuk ditampilkan di view
        $filterType = $request->get('filter_type', '');
        $year = (int) $request->get('year', date('Y'));
        $month = (int) $request->get('month', date('n'));
        $date = $request->get('date', '');
        $week = (int) $request->get('week', 0);

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
            $periodName = date('F Y', mktime(0, 0, 0, $month, 1, $year));
        } elseif ($filterType === 'yearly') {
            $periodType = 'TAHUNAN';
            $periodName = "Tahun $year";
        } else {
            $periodType = 'ALL';
        }

        // Totals dari rows
        $totalOrders = $rows->sum('total');
        $totalIncome = $rows->sum('income');
        $totalProfit = $rows->sum('profit');

        // Biaya operasional (dari tabel expenses) berdasarkan filter yang sama
        $expenses = $this->getExpensesSummary($filterType, $year, $month, $date, $week);
        $totalBiaya = array_sum($expenses);
        $netProfit = $totalProfit - $totalBiaya;

        // Data chart (bulanan dan tahunan)
        $chartData = $this->getChartData();

        // Kirim semua ke view
        return view('admin.reports', array_merge([
            'filterType' => $filterType,
            'year'       => $year,
            'month'      => $month,
            'date'       => $date,
            'week'       => $week,
            'periodType' => $periodType,
            'periodName' => $periodName,
            'totalOrders' => $totalOrders,
            'totalIncome' => $totalIncome,
            'totalProfit' => $totalProfit,
            'netProfit'  => $netProfit,
            'expenses'   => $expenses,
            'totalBiaya' => $totalBiaya,
            'rows'       => $rows,
        ], $chartData));
    }

    /**
     * Export laporan ke CSV.
     */
    public function exportReport(Request $request)
    {
        $role = auth()->user()->role ?? '';
        if (!in_array($role, ['dev', 'owner'])) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $rows = $this->getReportRows($request);

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="laporan_keuangan_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($rows) {
            $handle = fopen('php://output', 'w');
            fputs($handle, "\xEF\xBB\xBF"); // BOM UTF-8
            fputcsv($handle, ['Periode', 'Total Order', 'Total Income', 'Total Modal', 'Keuntungan']);

            foreach ($rows as $row) {
                fputcsv($handle, [
                    $row->period,
                    $row->total,
                    number_format($row->income, 0, ',', '.'),
                    number_format($row->modal, 0, ',', '.'),
                    number_format($row->profit, 0, ',', '.'),
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Halaman manajemen pengeluaran.
     */
    public function expenses(Request $request)
    {
        $role = auth()->user()->role ?? '';
        if (!in_array($role, ['dev', 'owner'])) {
            return redirect()->route('home')->with('error', 'Unauthorized access');
        }

        // Handle delete via GET
        if ($request->has('delete')) {
            $id = (int) $request->delete;
            DB::table('expenses')->where('id', $id)->delete();
            return redirect()->route('admin.expenses')->with('success', 'Pengeluaran berhasil dihapus.');
        }

        $editExpense = null;
        if ($request->has('edit')) {
            $editExpense = DB::table('expenses')->where('id', (int) $request->edit)->first();
        }

        $filterMonth = $request->get('month', '');
        $filterYear  = $request->get('year', '');
        $filterCategory = $request->get('category', '');
        $filterType = $request->get('type', ''); // daily / fixed

        $query = DB::table('expenses');
        if ($filterMonth) $query->whereMonth('expense_date', $filterMonth);
        if ($filterYear)  $query->whereYear('expense_date', $filterYear);
        if ($filterCategory) $query->where('category', $filterCategory);
        if ($filterType) $query->where('type', $filterType);
        $expenses = $query->orderBy('expense_date', 'DESC')->get();

        $totalPerCategory = [
            'gaji'        => $expenses->where('category', 'gaji')->sum('amount'),
            'operasional' => $expenses->where('category', 'operasional')->sum('amount'),
            'marketing'   => $expenses->where('category', 'marketing')->sum('amount'),
            'admin'       => $expenses->where('category', 'admin')->sum('amount'),
            'lainnya'     => $expenses->where('category', 'lainnya')->sum('amount'),
        ];
        $totalExpenses = $expenses->sum('amount');

        $categories = DB::table('expenses')->select('category')->distinct()->pluck('category');
        $types = ['daily' => 'Harian', 'fixed' => 'Tetap'];

        return view('admin.expenses', compact(
            'expenses',
            'totalExpenses',
            'totalPerCategory',
            'categories',
            'types',
            'filterMonth',
            'filterYear',
            'filterCategory',
            'filterType',
            'editExpense'
        ));
    }

    /**
     * Simpan (tambah/edit) pengeluaran.
     */
    public function saveExpense(Request $request)
    {
        $role = auth()->user()->role ?? '';
        if (!in_array($role, ['dev', 'owner'])) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $data = $request->validate([
            'category'    => 'required|string',
            'description' => 'required|string',
            'amount'      => 'required|numeric|min:0',
            'expense_date' => 'required|date',
            'type'        => 'required|in:daily,fixed',
            'edit_id'     => 'nullable|integer'
        ]);

        if ($data['edit_id'] > 0) {
            DB::table('expenses')->where('id', $data['edit_id'])->update([
                'category'    => $data['category'],
                'description' => $data['description'],
                'amount'      => $data['amount'],
                'expense_date' => $data['expense_date'],
                'type'        => $data['type'],
            ]);
            return redirect()->route('admin.expenses')->with('success', 'Pengeluaran berhasil diupdate!');
        } else {
            DB::table('expenses')->insert([
                'category'    => $data['category'],
                'description' => $data['description'],
                'amount'      => $data['amount'],
                'expense_date' => $data['expense_date'],
                'type'        => $data['type'],
                'created_by'  => auth()->id(),
                'created_at'  => now(),
            ]);
            return redirect()->route('admin.expenses')->with('success', 'Pengeluaran baru berhasil ditambahkan!');
        }
    }

    /**
     * Hapus pengeluaran (via GET).
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
     * Export pengeluaran (placeholder).
     */
    public function exportExpenses(Request $request)
    {
        return redirect()->route('admin.expenses')->with('info', 'Fitur export pengeluaran sedang dalam pengembangan.');
    }

    // ============================================================
    // PRIVATE HELPERS
    // ============================================================

    /**
     * Ambil data laporan berdasarkan filter.
     */
    private function getReportRows(Request $request)
    {
        $filterType = $request->get('filter_type', '');
        $year = (int) $request->get('year', date('Y'));
        $month = (int) $request->get('month', date('n'));
        $date = $request->get('date', '');
        $week = (int) $request->get('week', 0);

        if (!empty($filterType) && $year == 0) $year = date('Y');

        $dateFilter = '';
        if ($filterType === 'daily' && $date) {
            $dateFilter = "DATE(created_at) = '$date'";
        } elseif ($filterType === 'weekly' && $week > 0) {
            $dateFilter = "YEAR(created_at) = $year AND WEEK(created_at, 1) = $week";
        } elseif ($filterType === 'monthly' && $month > 0) {
            $dateFilter = "DATE_FORMAT(created_at,'%Y-%m') = '$year-" . str_pad($month, 2, '0', STR_PAD_LEFT) . "'";
        } elseif ($filterType === 'yearly' && $year > 0) {
            $dateFilter = "YEAR(created_at) = $year";
        }

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

        $query = DB::table('shipments as s')
            ->select(
                DB::raw("DATE_FORMAT(s.created_at, '$dateFormat') AS period"),
                DB::raw('COUNT(*) AS total'),
                DB::raw('SUM(s.charge_idr) AS income'),
                DB::raw('SUM(s.modal) AS modal'), // ← ambil modal
                DB::raw('SUM(s.charge_idr - s.modal) AS profit') // ← profit = harga jual - modal
            )
            ->where('s.status_pengerjaan', '!=', 'Cancelled');

        if ($dateFilter) {
            $query->whereRaw($dateFilter);
        }

        return $query->groupBy(DB::raw($groupBy))
            ->orderBy('period', 'DESC')
            ->get();
    }

    /**
     * Ringkasan pengeluaran berdasarkan filter.
     * Sekarang termasuk filter type (daily/fixed) dan menghitung total per kategori.
     */
    private function getExpensesSummary($filterType, $year, $month, $date, $week)
    {
        $hasExpenses = Schema::hasTable('expenses');
        $expenses = ['gaji' => 0, 'operasional' => 0, 'marketing' => 0, 'admin' => 0, 'lainnya' => 0];

        if ($hasExpenses) {
            $expQuery = DB::table('expenses');
            // Filter berdasarkan periode yang sama dengan laporan
            if ($filterType === 'daily' && $date) {
                $expQuery->whereDate('expense_date', $date);
            } elseif ($filterType === 'weekly' && $week > 0 && $year > 0) {
                // Untuk weekly, kita ambil semua dalam minggu tersebut
                $startDate = date('Y-m-d', strtotime($year . 'W' . str_pad($week, 2, '0', STR_PAD_LEFT) . '1'));
                $endDate = date('Y-m-d', strtotime($startDate . '+6 days'));
                $expQuery->whereBetween('expense_date', [$startDate, $endDate]);
            } elseif ($filterType === 'monthly' && $year > 0 && $month > 0) {
                $expQuery->whereMonth('expense_date', $month)->whereYear('expense_date', $year);
            } elseif ($filterType === 'yearly' && $year > 0) {
                $expQuery->whereYear('expense_date', $year);
            } else {
                // Default: jika tidak ada filter, ambil semua (atau batasi tahun berjalan?)
                // Biarkan semua
            }

            $expCategories = $expQuery->select('category', DB::raw('SUM(amount) as total'))
                ->groupBy('category')->get();

            foreach ($expCategories as $e) {
                if (array_key_exists($e->category, $expenses)) {
                    $expenses[$e->category] = $e->total;
                }
            }
        } else {
            // Dummy data jika tabel belum ada
            $expenses = ['gaji' => 15000000, 'operasional' => 5000000, 'marketing' => 3000000, 'admin' => 2000000, 'lainnya' => 0];
            if ($filterType === 'yearly') {
                foreach ($expenses as $key => $val) {
                    $expenses[$key] = $val * 12;
                }
            }
        }
        return $expenses;
    }

    /**
     * Data chart (harian dan bulanan) – sama seperti sebelumnya.
     */
    private function getChartData()
    {
        $currentYear = date('Y');
        $currentMonth = date('n');
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);

        // Daily chart untuk bulan ini
        $dailyData = [];
        $maxDailyRev = 0;
        for ($d = 1; $d <= $daysInMonth; $d++) {
            $dateStr = date('Y-m-d', mktime(0, 0, 0, $currentMonth, $d, $currentYear));
            $rev = DB::table('shipments')
                ->whereDate('created_at', $dateStr)
                ->where('status_pengerjaan', '!=', 'Cancelled')
                ->sum('charge_idr');
            $ord = DB::table('shipments')
                ->whereDate('created_at', $dateStr)
                ->where('status_pengerjaan', '!=', 'Cancelled')
                ->count();
            $dailyData[] = [
                'rev'   => $rev,
                'ord'   => $ord,
                'lbl'   => $d,
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

        // Monthly chart tahun ini
        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];
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
                'lbl' => $monthNames[$m - 1]
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

        return [
            'dailyData'      => $dailyData,
            'maxDailyRev'    => $maxDailyRev,
            'daysInMonth'    => $daysInMonth,
            'currentMonthRev' => $currentMonthRev,
            'currentMonthOrd' => $currentMonthOrd,
            'monthlyData'    => $monthlyData,
            'maxMonthlyRev'  => $maxMonthlyRev,
            'currentYearRev' => $currentYearRev,
            'currentYearOrd' => $currentYearOrd,
            'currentYear'    => $currentYear,
            'currentMonth'   => $currentMonth,
            'monthNames'     => $monthNames,
        ];
    }
}
