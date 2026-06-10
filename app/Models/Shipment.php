<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Auditable;
use Illuminate\Support\Facades\DB;

class Shipment extends Model
{
    use HasFactory;
    use Auditable;

    protected $table = 'shipments';

    protected $fillable = [
    'nomor_inv',
    'tanggal',
    'nama_customer',
    'phone_customer',
    'alamat_customer',
    'nama_penerima',
    'nomor_hp_penerima',
    'email_penerima',
    'alamat_penerima',
    'receiver_city',      // tambahkan
    'receiver_zip',       // tambahkan
    'last_mail',
    'service',
    'negara',
    'zona',
    'awb',
    'berat_fisik',
    'panjang',
    'lebar',
    'tinggi',
    'volumetrik',
    'berat_dibebankan',
    'duty_19',
    'charge_idr',
    'content',
    'declare_value_usd',
    'tracking_number',
    'tracking_lanjutan',
    'duty',
    'status_pengerjaan',
    'vat_number',
    'frdm',
    'user_id',
    ];  

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tracking()
    {
        return $this->hasMany(Tracking::class, 'tracking_number', 'tracking_number');
    }

public function invoices()
{
    return $this->belongsToMany(Invoice::class, 'invoice_items', 'shipment_id', 'invoice_id');
}

// Hapus accessor getInvoiceAttribute karena tidak perlu, atau bisa dipertahankan dengan nama yang berbeda
// Jika tetap ingin accessor, gunakan:
public function getInvoiceAttribute()
{
    return $this->invoices->first();
}

        public function getEstimatedDeliveryAttribute()
{
    $service = strtolower($this->service ?? '');

    $fixedTimes = [
        'dhl'   => '3-5 hari kerja',
        'fedex' => '12-15 hari kerja',
        'tge'   => '5-7 hari kerja',
        'tlx'   => '5-7 hari kerja',
        'usps'  => '12-14 hari kerja'
    ];

    if (isset($fixedTimes[$service])) {
        return $fixedTimes[$service];
    }

    if ($service === 'singpost' && !empty($this->negara)) {
        $country = DB::table('countries')->where('country_name', $this->negara)->first();
        if ($country) {
            // Ambil satu record singpost_rate (transit time sama untuk semua berat)
            $rate = DB::table('singpost_rate')
                ->where('origin_country_id', 1)
                ->where('destination_country_id', $country->id)
                ->first();

            if ($rate && isset($rate->delivery_time_min, $rate->delivery_time_max)) {
                return $rate->delivery_time_min . '-' . $rate->delivery_time_max . ' hari kerja';
            }
        }
        return '12-15 hari kerja';
    }

    return null;
}
}