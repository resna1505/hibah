<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
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
        //
        Schema::defaultStringLength(191);

        // Saat aplikasi diakses publik di belakang reverse proxy (Nginx, dll),
        // host request bisa terdeteksi sebagai "localhost"/IP internal, sehingga
        // route(), url(), redirect()->to(), dan link di email/notifikasi
        // menghasilkan alamat yang salah (mengarah ke localhost).
        //
        // Selama APP_URL sudah diisi domain publik (mis. https://hibahlppm.univbatam.ac.id),
        // paksa semua URL absolut memakai domain & skema dari APP_URL.
        $appUrl = (string) config('app.url');
        if ($appUrl !== '' && ! str_contains($appUrl, 'localhost') && ! str_contains($appUrl, '127.0.0.1')) {
            URL::forceRootUrl($appUrl);
            if (str_starts_with($appUrl, 'https://')) {
                URL::forceScheme('https');
            }
        }
    }
}
