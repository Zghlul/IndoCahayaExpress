<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RateController extends Controller
{
    // Mapping layanan ke tabel rate
    private $tableMap = [
        'PRIORITY'   => 'dhl_rate',
        'fedex'      => 'fedex_rate',
        'REGULER'    => 'singpost_rate',
        'US REGULER' => 'usps_rate',
        'FAST ASIAN' => 'tlx_rate',
        'FLASH'      => 'aramex_rate',
        'FLASH AUSSY' => 'tge_rate',
    ];

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:access admin panel');
    }

    /**
     * Halaman utama rates dengan semua vendor dan filter.
     */
    public function index(Request $request)
    {
        $role = auth()->user()->role ?? '';
        if (!in_array($role, ['admin', 'owner', 'dev'])) {
            return redirect()->route('home')->with('error', 'Unauthorized');
        }

        $vendorTables = [
            'PRIORITY'   => 'dhl_rate',
            'fedex'      => 'fedex_rate',
            'REGULER'    => 'singpost_rate',
            'US REGULER' => 'usps_rate',
            'FAST ASIAN' => 'tlx_rate',
            'FLASH'      => 'aramex_rate',
            'FLASH AUSSY' => 'tge_rate',
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
            'vendorRates',
            'vendorCounts',
            'countries',
            'totalCountries',
            'totalAllRates',
            'search'
        ));
    }

    /**
     * Update single rate (hanya dev).
     */
    public function update(Request $request)
    {
        $role = auth()->user()->role ?? '';
        if ($role !== 'dev') {
            return redirect()->route('admin.rates')->with('error', 'Unauthorized');
        }

        $vendor = $request->input('vendor');
        $rateId = $request->input('rate_id');
        $price  = (float) $request->input('price');
        $modal  = (float) $request->input('modal');
        $weight = (float) $request->input('weight_kg');

        $tableMap = [
            'PRIORITY'   => 'dhl_rate',
            'fedex'      => 'fedex_rate',
            'REGULER'    => 'singpost_rate',
            'US REGULER' => 'usps_rate',
            'FAST ASIAN' => 'tlx_rate',
            'FLASH'      => 'aramex_rate',
            'FLASH AUSSY' => 'tge_rate',
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

    /**
     * Tambah negara baru (hanya dev).
     */
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

    /**
     * Update nama negara (hanya dev).
     */
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

    /**
     * Hapus negara beserta semua rates terkait (hanya dev).
     */
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

    /**
     * Reset semua rates (truncate semua tabel rate, hanya dev).
     */
    public function reset()
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
}
