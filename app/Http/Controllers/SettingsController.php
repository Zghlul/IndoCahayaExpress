<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.settings', compact('settings'));
    }

    public function saveGeneral(Request $request)
    {
        Setting::set('site_name', $request->site_name);
        Setting::set('site_tagline', $request->site_tagline);
        Setting::set('site_email', $request->site_email);
        Setting::set('site_phone', $request->site_phone);
        Setting::set('site_address', $request->site_address);
        Setting::set('maintenance_mode', $request->has('maintenance_mode') ? '1' : '0');

        Cache::forget('global_settings');
        return back()->with('flash_settings', 'Pengaturan umum berhasil disimpan.');
    }

    public function saveSmtp(Request $request)
    {
        Setting::set('smtp_host', $request->smtp_host);
        Setting::set('smtp_port', $request->smtp_port);
        Setting::set('smtp_user', $request->smtp_user);
        Setting::set('smtp_pass', $request->smtp_pass);
        Setting::set('smtp_encryption', $request->smtp_encryption);
        Setting::set('mail_from_name', $request->mail_from_name);
        Setting::set('mail_from_email', $request->mail_from_email);

        Cache::forget('global_settings');
        return back()->with('flash_settings', 'Pengaturan SMTP berhasil disimpan.');
    }

    public function saveShipping(Request $request)
    {
        Setting::set('default_currency', $request->default_currency);
        Setting::set('weight_unit', $request->weight_unit);
        Setting::set('dimension_unit', $request->dimension_unit);
        Setting::set('max_weight', $request->max_weight);
        Setting::set('insurance_rate', $request->insurance_rate);
        Setting::set('fuel_surcharge', $request->fuel_surcharge);

        Cache::forget('global_settings');
        return back()->with('flash_settings', 'Pengaturan shipping berhasil disimpan.');
    }

    public function saveSecurity(Request $request)
    {
        Setting::set('session_lifetime', $request->session_lifetime);
        Setting::set('max_login_attempts', $request->max_login_attempts);
        Setting::set('lockout_duration', $request->lockout_duration);
        Setting::set('require_email_verify', $request->has('require_email_verify') ? '1' : '0');
        Setting::set('two_factor_admin', $request->has('two_factor_admin') ? '1' : '0');

        Cache::forget('global_settings');
        return back()->with('flash_settings', 'Pengaturan keamanan berhasil disimpan.');
    }

    public function saveApi(Request $request)
    {
        Setting::set('google_maps_key', $request->google_maps_key);
        Setting::set('recaptcha_site_key', $request->recaptcha_site_key);
        Setting::set('recaptcha_secret_key', $request->recaptcha_secret_key);
        Setting::set('whatsapp_api_token', $request->whatsapp_api_token);
        Setting::set('whatsapp_number', $request->whatsapp_number);

        Cache::forget('global_settings');
        return back()->with('flash_settings', 'Pengaturan API berhasil disimpan.');
    }

    public function clearCache()
    {
        Cache::flush();
        return back()->with('flash_settings', 'Cache berhasil dibersihkan.');
    }

    public function resetSettings()
    {
        // Reset ke default (opsional)
        Setting::set('site_name', 'Indo Cahaya Express');
        Setting::set('site_tagline', 'Fast & Reliable Shipping');
        Setting::set('site_email', 'info@indocahayaexpress.com');
        Setting::set('site_phone', '+6281316048642');
        Setting::set('site_address', 'Jl. Sudirman No. 123, Jakarta Pusat');
        Setting::set('maintenance_mode', '0');
        // ... reset lainnya jika perlu

        Cache::forget('global_settings');
        return back()->with('flash_settings', 'Semua pengaturan telah direset ke default.');
    }
    /**
     * Simpan pengaturan berdasarkan action dari form.
     */
    public function save(Request $request)
    {
        $action = $request->input('action');

        switch ($action) {
            case 'save_general':
                return $this->saveGeneral($request);
            case 'save_smtp':
                return $this->saveSmtp($request);
            case 'save_shipping':
                return $this->saveShipping($request);
            case 'save_security':
                return $this->saveSecurity($request);
            case 'save_api':
                return $this->saveApi($request);
            default:
                return back()->with('flash_settings', 'Aksi tidak valid.');
        }
    }

    /**
     * Toggle maintenance mode via AJAX.
     */
    public function toggleMaintenance(Request $request)
    {
        $current = Setting::get('maintenance_mode', '0');
        $new = $current == '1' ? '0' : '1';
        Setting::set('maintenance_mode', $new);
        Cache::forget('global_settings');

        return response()->json(['success' => true, 'mode' => $new]);
    }
}
