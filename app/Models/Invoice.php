<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use App\Services\ExchangeRateService;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';

    protected $fillable = [
        'nomor_inv',
        'nama_customer',
        'email_customer',
        'subtotal',
        'ddp',
        'war_risk_charge',
        'aramex_surcharge',
        'grand_total',
        'status',
        'created_by',
        'catatan',
    ];

    protected $casts = [
        'subtotal'          => 'decimal:2',
        'ddp'               => 'decimal:2',
        'war_risk_charge'   => 'decimal:2',
        'aramex_surcharge'  => 'decimal:2',
        'grand_total'       => 'decimal:2',
        'created_at'        => 'datetime',
    ];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function shipments()
    {
        return $this->belongsToMany(Shipment::class, 'invoice_items', 'invoice_id', 'shipment_id','id')
                    ->withPivot('nama_penerima', 'ongkir')
                    ->withTimestamps();
    }

    /**
     * Hitung ulang subtotal, war_risk_charge, ddp, dan grand_total
     */
     public static function recalculate($invoiceId)
    {
        $invoice = self::find($invoiceId);
        if (!$invoice) return false;

        $items = InvoiceItem::where('invoice_id', $invoiceId)
                    ->with('shipment')
                    ->get();

        $subtotal = 0;
        $warRiskCharge = 0;
        $aramexSurcharge = 0;

        $warRiskServices = ['REGULER'];
        $warRiskPercent = setting('war_risk_percent', 32);

        // Daftar negara pengecualian Aramex (sama seperti di controller)
        $aramexExceptionCountries = [
            'Afghanistan', 'Armenia', 'Azerbaijan', 'Brunei',
            'Cambodia', 'China', 'Hong Kong', 'Indonesia',
            'Japan', 'Kazakhstan', 'Kyrgyzstan', 'Laos',
            'Macau', 'Malaysia', 'Mongolia', 'Myanmar',
            'Philippines', 'Singapore', 'South Korea', 'Taiwan',
            'Tajikistan', 'Thailand', 'Timor-Leste', 'Turkmenistan',
            'Uzbekistan', 'Vietnam', 'Australia', 'New Zealand',
            'Fiji'
        ];

        foreach ($items as $item) {
            $ongkir = (float) $item->ongkir; // ini adalah charge_idr dari shipment (sudah termasuk surcharge? TIDAK, kita ubah)
            $shipment = $item->shipment;
            if (!$shipment) continue;

            // Subtotal tetap menggunakan ongkir dari shipment
            $subtotal += $ongkir;

            // War Risk Charge (hanya REGULER)
            if (in_array($shipment->service, $warRiskServices)) {
                $warRiskCharge += $ongkir * ($warRiskPercent / 100);
            }

            // Aramex surcharge: hitung dari berat dan negara (tidak dari ongkir)
            if ($shipment->service === 'FLASH' && !in_array($shipment->negara, $aramexExceptionCountries)) {
                $berat = (float) $shipment->berat_dibebankan;
                if ($berat <= 2) {
                    $aramexSurcharge += 100000;
                } else {
                    $rounded = ceil($berat);
                    $aramexSurcharge += 50000 * $rounded;
                }
            }
        }

        $ddp = $invoice->calculateDDPFromShipments();

        $grandTotal = $subtotal + $warRiskCharge + $aramexSurcharge + $ddp;

        $invoice->subtotal = $subtotal;
        $invoice->war_risk_charge = round($warRiskCharge, 2);
        $invoice->aramex_surcharge = round($aramexSurcharge, 2);
        $invoice->ddp = $ddp;
        $invoice->grand_total = $grandTotal;
        $invoice->save();

        return true;
    }

    /**
     * Hitung DDP berdasarkan shipment (sama seperti sebelumnya)
     */
/**
 * Hitung DDP hanya dari shipment yang negaranya termasuk DDP countries.
 */
public function calculateDDPFromShipments()
{
    $ddpCountries = ['United States', 'USA', 'US', 'United States of America & Territories'];
    $ddpPercent = setting('ddp_percent', 19);
    $shipmentIds = $this->items()->pluck('shipment_id');
    if ($shipmentIds->isEmpty()) return 0.0;

    $shipments = Shipment::whereIn('id', $shipmentIds)->get(['negara', 'declare_value_usd', 'service']);

    $totalDDPValueUSD = 0;
    foreach ($shipments as $ship) {
        if (in_array($ship->negara, $ddpCountries) && $ship->service === 'REGULER') {
            $totalDDPValueUSD += (float) $ship->declare_value_usd;
        }
    }

    if ($totalDDPValueUSD <= 0) return 0.0;

    $exchangeRateService = new \App\Services\ExchangeRateService();
    $exchangeRate = $exchangeRateService->getUsdToIdrRate();

    return round($totalDDPValueUSD * $exchangeRate * ($ddpPercent / 100), 2);
}

    private function getExchangeRateUSDToIDR()
    {
        if (class_exists(\App\Models\Setting::class)) {
            $rate = Setting::where('key', 'usd_to_idr')->value('value');
            if ($rate) return (float) $rate;
        }
        return 15000.0;
    }

    public function getJumlahPaketAttribute()
    {
        return $this->items()->count();
    }

    /**
 * Recalculate DDP untuk semua invoice (atau hanya yang unpaid)
 * Dipanggil saat persentase DDP diubah di Settings
 */
public static function recalculateAllDDP($onlyUnpaid = true)
{
    $query = self::query();
    if ($onlyUnpaid) {
        $query->where('status', 'Unpaid');
    }
    $invoices = $query->get();
    
    foreach ($invoices as $invoice) {
        self::recalculate($invoice->id);
    }
    
    return $invoices->count();
}
}