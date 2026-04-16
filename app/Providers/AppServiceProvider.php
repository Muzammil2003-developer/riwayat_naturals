<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view->with('siteSettings', [
                'site_name' => Setting::get('site_name', 'Riwayat Naturals'),
                'tagline' => Setting::get('tagline', '100% Natural Hair Care'),
                'logo' => Setting::get('logo', ''),
                'phone' => Setting::get('phone', '+1 234 567 890'),
                'email' => Setting::get('email', 'info@riwayathair.com'),
                'announcement_text' => Setting::get('announcement_text', 'Rivaaj Mahal Official WhatsApp Numbers : 0327 2222189'),
                'currency_symbol' => Setting::get('currency_symbol', 'Rs.'),
            ]);
        });
    }
}
