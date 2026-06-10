<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $settings = Setting::getAll();

        // Override mail config
        if (!empty($settings['smtp_host']) && !empty($settings['smtp_user'])) {
            Config::set('mail.mailers.smtp.host', $settings['smtp_host']);
            Config::set('mail.mailers.smtp.port', $settings['smtp_port'] ?? 587);
            Config::set('mail.mailers.smtp.username', $settings['smtp_user']);
            Config::set('mail.mailers.smtp.password', $settings['smtp_pass'] ?? '');
            Config::set('mail.mailers.smtp.encryption', $settings['smtp_encryption'] ?? 'tls');
            Config::set('mail.from.address', $settings['mail_from_email'] ?? $settings['site_email'] ?? 'noreply@example.com');
            Config::set('mail.from.name', $settings['mail_from_name'] ?? $settings['site_name'] ?? 'Indo Cahaya Express');
        }

        // Shipping settings
        Config::set('app.default_currency', $settings['default_currency'] ?? 'IDR');
        Config::set('app.weight_unit', $settings['weight_unit'] ?? 'kg');
        Config::set('app.dimension_unit', $settings['dimension_unit'] ?? 'cm');
        Config::set('app.max_weight', (float) ($settings['max_weight'] ?? 30));
        Config::set('app.war_risk_percent', (float) ($settings['war_risk_percent'] ?? 32)); // tambahkan
        Config::set('app.ddp_percent', (float) ($settings['ddp_percent'] ?? 19));

        // Global view composer
        View::composer('*', function ($view) use ($settings) {
            $view->with('globalSettings', $settings);
        });
    }
}