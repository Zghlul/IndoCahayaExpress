<?php

namespace App\ViewComposers;

use App\Models\Setting;
use Illuminate\View\View;

class SettingsComposer
{
    public function compose(View $view)
    {
        // Ambil semua setting atau hanya yang sering dipakai
        $settings = [
            'site_name'        => Setting::get('site_name', 'Indo Cahaya Express'),
            'site_tagline'     => Setting::get('site_tagline', 'Fast & Reliable Shipping'),
            'site_email'       => Setting::get('site_email', 'info@indocahayaexpress.com'),
            'site_phone'       => Setting::get('site_phone', '081316048642'),
            'site_address'     => Setting::get('site_address', 'Perum Citra Indah, Bukit Amarilis AR 00 no. 010'),
            'maintenance_mode' => Setting::get('maintenance_mode', '0'),
            // Tambahkan setting lain jika diperlukan
        ];

        $view->with('globalSettings', $settings);
    }
}