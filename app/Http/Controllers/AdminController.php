<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Traits\LogsActivity;
use App\Models\ActivityLog;

class AdminController extends Controller
{
    use LogsActivity;

    /**
     * Dashboard utama admin.
     */
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

    /**
     * Halaman aktivitas log.
     */
    public function activityLogs()
    {
        $logs = ActivityLog::with('user')->latest()->paginate(50);
        return view('admin.activity_logs', compact('logs'));
    }

    /**
     * Ranking customer berdasarkan total pengiriman dan pengeluaran.
     */
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

        return view('admin.ranking', compact(
            'rankingData',
            'totalCustomers',
            'totalShipmentsDelivered',
            'totalRevenue'
        ));
    }
}
