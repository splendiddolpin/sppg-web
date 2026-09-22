<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // 1. Tambahkan baris ini di atas

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
        // 2. Tambahkan logika ini:
        // Jika aplikasi tidak berjalan di environment 'local' (Laragon), paksa gunakan HTTPS
        if (config('app.env') !== 'local') {
            URL::forceScheme('https');
        }
    }
}
