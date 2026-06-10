<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Shipment;
use Illuminate\Support\Facades\Auth;
use App\Traits\LogsActivity;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ShipmentController extends Controller {
    use LogsActivity;

    public function index() {
        $countries = DB::table('countries')
            ->where('country_name', '!=', 'Indonesia')
            ->orderBy('country_name')
            ->get();

        return view('home', compact('countries'));
    }

    public function book() {
        $countries = DB::table('countries')->where('country_name', '!=', 'Indonesia')->orderBy('country_name')->get();
        $weightUnit = Config::get('app.weight_unit', 'kg');
        $dimensionUnit = Config::get('app.dimension_unit', 'cm');
        return view('shipment.book', compact('countries', 'weightUnit', 'dimensionUnit'));
    }

    public function store(Request $request)
{
    // Ambil max weight dari config (default 70 kg)
    $maxWeight = Config::get('app.max_weight', 70);

    $validated = $request->validate([
        'receiver_name' => ['required', 'string', 'max:255'],
        'receiver_email' => ['required', 'email'],
        'receiver_country' => ['required'],
        'receiver_city' => ['required', 'string'],
        'receiver_zip' => ['required', 'string'],
        'receiver_address1' => ['required', 'string'],
        'receiver_phone' => ['required', 'string'],
        'weight' => ['required', 'numeric', 'min:0.1', 'max:' . $maxWeight],
        'length' => ['required', 'numeric', 'min:1'],
        'width' => ['required', 'numeric', 'min:1'],
        'height' => ['required', 'numeric', 'min:1'],
        'content_description' => ['required', 'string'],
        'item_qty' => ['required', 'integer', 'min:1'],
        'item_value' => ['required', 'numeric', 'min:0'],
        'terms_accepted' => ['accepted'],
    ]);
    $user = auth()->user();

    $volumetric = ($request->length * $request->width * $request->height) / 5000;
    if ($request->service === 'REGULER') {
        $chargeable_weight = $request->weight; // hanya berat fisik
    } else {
        $volumetric = ($request->length * $request->width * $request->height) / 5000;
        $chargeable_weight = max($request->weight, $volumetric);
    }

    $tracking_number = 'ICE' . date('Ymd') . strtoupper(substr(md5(uniqid()), 0, 8));

    $country = DB::table('countries')->where('id', $request->receiver_country)->first();
    $country_name = $country ? $country->country_name : '';

    $full_phone = ($request->receiver_phone_code ?? '+62') . $request->receiver_phone;

    $alamat_penerima = $request->receiver_address1;
    if ($request->receiver_address2) {
        $alamat_penerima .= ', ' . $request->receiver_address2;
    }
    $alamat_penerima .= ', ' . $request->receiver_city . ', ' . $request->receiver_zip;

    $sender_name    = $user->name ?? 'Guest';
    $sender_phone   = $user->phone ?? $user->no_telp ?? '0000000000';
    $sender_address = $user->kota ?? $user->address ?? 'Not provided';

    DB::table('shipments')->insert([
        'tanggal' => now()->toDateString(),
        'nama_customer'      => $sender_name,
        'phone_customer'     => $sender_phone,
        'alamat_customer'    => $sender_address,
        'nama_penerima'      => $validated['receiver_name'],
        'nomor_hp_penerima'  => $full_phone,
        'email_penerima'     => $validated['receiver_email'],
        'alamat_penerima'    => $alamat_penerima,
        'receiver_city'      => $request->receiver_city,
        'receiver_zip'       => $request->receiver_zip,
        'service'            => $request->service,
        'negara'             => $country_name,
        'berat_fisik'        => $validated['weight'],
        'panjang'            => $validated['length'],
        'lebar'              => $validated['width'],
        'tinggi'             => $validated['height'],
        'volumetrik'         => $volumetric,
        'berat_dibebankan'   => $chargeable_weight,
        'charge_idr'         => $request->price ?: 0,
        'content'            => $validated['content_description'],
        'declare_value_usd'  => $validated['item_value'],
        'tracking_number'    => $tracking_number,
        'status_pengerjaan'  => 'Pending',
        'vat_number'         => $request->vat_number,
        'user_id'            => $user->id,
        'created_at'         => now(),
        'updated_at'         => now(),
    ]);

    DB::table('tracking')->insert([
        'tracking_number' => $tracking_number,
        'status' => 'pending',
        'location' => 'Jakarta, Indonesia',
        'description' => 'Shipment created, waiting for pickup',
        'created_at' => now(),
    ]);

    // Kirim data ke Google Spreadsheet (dengan timeout dan error handling)
    $googleScriptUrl = 'https://script.google.com/macros/s/AKfycbxuzKtBFyxj4EwiiZ4rdmTiwy0Zt9nCYQf3aoc1rFrnDO9IwRtcnofNxLkaqHS9m9QQzA/exec';

    $dataToSend = [
        'nama_pengirim'      => $sender_name,
        'email_pengirim'     => $user->email ?? '',
        'receiver_name'      => $validated['receiver_name'],
        'receiver_email'     => $validated['receiver_email'],
        'receiver_country'   => $country_name,
        'receiver_city'      => $request->receiver_city,
        'receiver_zip'       => $request->receiver_zip,
        'receiver_phone'     => $full_phone,
        'weight'             => $validated['weight'],
        'length'             => $validated['length'],
        'width'              => $validated['width'],
        'height'             => $validated['height'],
        'service'            => $request->service,
        'price'              => $request->price ?: 0,
        'content_description'=> $validated['content_description'],
        'item_qty'           => $validated['item_qty'],
        'item_value'         => $validated['item_value'],
        'vat_number'         => $request->vat_number,
        'notes'              => $request->notes,
        'tracking_number'    => $tracking_number,
    ];

    try {
        $response = Http::timeout(10)->post($googleScriptUrl, $dataToSend);
        Log::info('Google Sheet Response', ['status' => $response->status(), 'body' => $response->body()]);
    } catch (\Exception $e) {
        Log::error('Google Sheet send failed: ' . $e->getMessage());
    }

    return redirect()->route('tracking.index')->with('success', 'Shipment created successfully! Tracking number: ' . $tracking_number);
}
    public function invoices() {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $invoices = DB::table('invoices')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('shipment.invoices', compact('invoices'));
    }

    public function calculator() {
        $countries = DB::table('countries')->where('country_name', '!=', 'Indonesia')->orderBy('country_name')->get();
        $weightUnit = Config::get('app.weight_unit', 'kg');
        $dimensionUnit = Config::get('app.dimension_unit', 'cm');
        return view('calculator', compact('countries', 'weightUnit', 'dimensionUnit'));
    }

    public function calculateRate(Request $request)
    {
        $request->validate([
            'country' => 'required|exists:countries,id',
            'weight'  => 'required|numeric|min:0.001',
            'length'  => 'nullable|numeric|min:0',
            'width'   => 'nullable|numeric|min:0',
            'height'  => 'nullable|numeric|min:0',
        ]);

        $startTime = microtime(true);
        $startMemory = memory_get_usage();    
        $countryId = $request->input('country');
        $weight = (float) $request->input('weight');
        $length = (float) $request->input('length');
        $width  = (float) $request->input('width');
        $height = (float) $request->input('height');

        $volumetric = ($length * $width * $height) / 5000;
        $finalWeight = max($weight, $volumetric);

        // Validasi max weight dari config
        $maxWeight = Config::get('app.max_weight', 70);
        if ($finalWeight > $maxWeight) {
            return response()->json([
                'error' => true,
                'message' => "Berat paket melebihi batas maksimum {$maxWeight} kg."
            ], 422);
        }

        $country = DB::table('countries')->where('id', $countryId)->first();
        $countryName = $country ? $country->country_name : '';

        $vendors = [
            ['name' => 'PRIORITY',    'table' => 'dhl_rate',     'color' => '#ffaa22', 'maxWeight' => 30],
            ['name' => 'FedEx',       'table' => 'fedex_rate',   'color' => '#7c3aed', 'maxWeight' => 30],
            ['name' => 'US REGULER',  'table' => 'usps_rate',    'color' => '#2563eb', 'maxWeight' => 2.0],
            ['name' => 'REGULER',     'table' => 'singpost_rate','color' => '#059669', 'maxWeight' => 2.0],
            ['name' => 'FAST ASIA',   'table' => 'tlx_rate',     'color' => '#075999', 'maxWeight' => 30.0],
            ['name' => 'FLASH',       'table' => 'aramex_rate',  'color' => '#ff0000', 'maxWeight' => 20.0],
            ['name' => 'FLASH AUSSY', 'table' => 'tge_rate',     'color' => '#09461d', 'maxWeight' => 30.0],
        ];

        foreach ($vendors as &$vendor) {
            // Tentukan berat yang digunakan untuk vendor ini
            $isReguler = ($vendor['name'] === 'REGULER');
            $weightForVendor = $isReguler ? $weight : $finalWeight;

            // Validasi max weight
            if ($weightForVendor > $vendor['maxWeight']) {
                $vendor['available'] = false;
                $vendor['price'] = null;
                $vendor['weight_used'] = $weightForVendor;
                continue;
            }

            // Cek rate di tabel
            $rate = DB::table($vendor['table'])
                ->where('destination_country_id', $countryId)
                ->where('weight_kg', '>=', $weightForVendor)
                ->orderBy('weight_kg', 'asc')
                ->first();

            if ($rate) {
                $price = (float) $rate->price;
                
                $vendor['price'] = $price;
                $vendor['available'] = true;
                $vendor['weight_used'] = $weightForVendor;
            } else {
                $vendor['available'] = false;
                $vendor['price'] = null;
                $vendor['weight_used'] = $weightForVendor;
            }
        }

        $endTime = microtime(true);
        $executionTime = ($endTime - $startTime) * 1000;
        $memoryUsed = memory_get_usage() - $startMemory;

        \Log::info('CalculateRate performance', [
            'execution_time_ms' => $executionTime,
            'memory_used_bytes' => $memoryUsed,
            'country_id' => $countryId,
            'final_weight' => $finalWeight,
        ]);

        $deliveryMap = [
        'PRIORITY'    => '3-5 hari kerja',
        'FedEx'       => '12-15 hari kerja',
        'US REGULER'  => '7-14 hari kerja',
        'FAST ASIA'   => '5-7 hari kerja',
        'FLASH AUSSY' => '5-7 hari kerja',
    ];

    foreach ($vendors as &$vendor) {
        $isReguler = ($vendor['name'] === 'REGULER');
        $weightForVendor = $isReguler ? $weight : $finalWeight;

        if ($weightForVendor > $vendor['maxWeight']) {
            $vendor['available'] = false;
            $vendor['price'] = null;
            $vendor['weight_used'] = $weightForVendor;
            $vendor['estimated_delivery'] = null;
            continue;
        }

        $rate = DB::table($vendor['table'])
            ->where('destination_country_id', $countryId)
            ->where('weight_kg', '>=', $weightForVendor)
            ->orderBy('weight_kg', 'asc')
            ->first();




        if ($rate) {
            $vendor['price'] = (float) $rate->price;
            $vendor['available'] = true;
            $vendor['weight_used'] = $weightForVendor;

            // Isi estimasi waktu
            if ($isReguler) {
                $min = $rate->delivery_time_min ?? null;
                $max = $rate->delivery_time_max ?? null;
                $vendor['estimated_delivery'] = ($min && $max) ? "{$min}-{$max} hari kerja" : '12-15 hari kerja';
            } else {
                $vendor['estimated_delivery'] = $deliveryMap[$vendor['name']] ?? 'estimasi tidak tersedia';
            }

            $surcharges = [];
            if ($vendor['name'] === 'REGULER') {
                $surcharges[] = 'War Risk';
                if (in_array($countryId, [65, 213])) {
                    $surcharges[] = 'DDP (Duty & Tax)';
                }
            } elseif ($vendor['name'] === 'FLASH') {
                $surcharges[] = 'Biaya TESS';
                $min = $rate->delivery_time_min ?? null;
                $max = $rate->delivery_time_max ?? null;
                $vendor['estimated_delivery'] = ($min && $max) ? "{$min}-{$max} hari kerja" : '3-5 hari kerja';
            }
            $vendor['surcharge_info'] = empty($surcharges) ? 'Tidak ada' : implode(' + ', $surcharges);

        } else {
             $vendor['available'] = false;
             $vendor['price'] = null;
             $vendor['weight_used'] = $weightForVendor;
             $vendor['estimated_delivery'] = null;
             $vendor['surcharge_info'] = null;
        }

    }

        return response()->json([
            'country_name' => $countryName,
            'final_weight' => $finalWeight,
            'volumetric_weight' => $volumetric,
            'actual_weight' => $weight,
            'vendors' => $vendors,
            'length' => $length,
            'width' => $width,
            'height' => $height,
        ]);
    }
}
