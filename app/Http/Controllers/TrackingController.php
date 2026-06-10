<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipment; // Sesuaikan dengan model Anda
use App\Traits\LogsActivity;
use Illuminate\Support\Facades\DB;

class TrackingController extends Controller
{
    use LogsActivity;
    
    // Menampilkan halaman tracking (form)
    public function index()
    {
        return view('tracking.index');
    }

    // Memproses pencarian tracking number
    public function track(Request $request)
    {
        $request->validate([
            'tracking_number' => 'required|string|max:100',
        ]);

        $trackingNumber = trim($request->input('tracking_number'));

        // Query sesuai dengan struktur database Anda (shipments_new join countries)
        $shipment = DB::table('shipments')
            ->join('countries', DB::raw('CONVERT(shipments.negara USING utf8mb4)'), '=', DB::raw('CONVERT(countries.country_name USING utf8mb4)'))
            ->where('shipments.tracking_number', $trackingNumber)
            ->select('shipments.*', 'countries.country_name')
            ->first();

        return view('tracking.index', [
            'trackingNumber' => $trackingNumber,
            'shipment'       => $shipment,
        ]);
    }
}