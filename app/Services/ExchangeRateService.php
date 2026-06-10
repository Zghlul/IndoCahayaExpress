<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ExchangeRateService
{
    /**
     * Ambil kurs USD ke IDR.
     * Data akan di-cache selama 60 menit.
     */
    public function getUsdToIdrRate(): float
    {
        return Cache::remember('usd_to_idr_rate', 3600, function () {
            // Opsi 1: Frankfurter API (gratis, tanpa key)
            $response = Http::get('https://api.frankfurter.app/latest', [
                'from' => 'USD',
                'to'   => 'IDR',
            ]);

            if ($response->successful()) {
                $rate = $response->json('rates.IDR');
                if ($rate) {
                    return (float) $rate;
                }
            }

            // Opsi 2: ExchangeRate-API (gratis tanpa key, limit 1500 request/bulan)
            $response2 = Http::get('https://api.exchangerate-api.com/v4/latest/USD');
            if ($response2->successful()) {
                $rate = $response2->json('rates.IDR');
                if ($rate) {
                    return (float) $rate;
                }
            }

            // Fallback jika semua API gagal
            logger()->error('Gagal mengambil kurs USD/IDR dari API, menggunakan nilai default.');
            return 15000.00;
        });
    }
}