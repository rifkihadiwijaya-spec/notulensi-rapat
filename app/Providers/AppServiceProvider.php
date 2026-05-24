<?php

namespace App\Providers;

use App\Models\Meeting;
use App\Policies\MeetingPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;
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
        Carbon::setLocale('id');

        Gate::policy(Meeting::class, MeetingPolicy::class);

        // ── RISIKO #4 SEDANG: Force HTTPS di production ─────────────────────
        // Memastikan semua URL yang digenerate Laravel (redirect, asset, dll.)
        // menggunakan skema HTTPS saat aplikasi berjalan di environment production.
        // Pastikan APP_ENV=production di file .env server Anda.
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}