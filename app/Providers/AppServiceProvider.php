<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;
use App\Models\Visit;
use Illuminate\Support\Facades\Auth;

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
        if (app()->environment('production') || str_contains(config('app.url'), 'ngrok')) {
            URL::forceScheme('https');
        }

        // Track visitor untuk setiap request (public & authenticated)
        if (!app()->runningInConsole()) {
            $this->trackVisitor();
        }
    }

    /**
     * Track visitor unik per hari berdasarkan IP
     */
    protected function trackVisitor(): void
    {
        try {
            $ip = request()->ip();
            $userId = Auth::id();
            $date = now()->toDateString();

            // Cek apakah sudah ada kunjungan hari ini dari IP ini
            $exists = Visit::where('ip', $ip)->where('date', $date)->exists();
            if (!$exists) {
                Visit::create([
                    'ip' => $ip,
                    'user_id' => $userId,
                    'date' => $date
                ]);
            }
        } catch (\Exception $e) {
            // Silent fail untuk tidak mengganggu aplikasi
            Log::error('Visitor tracking failed: ' . $e->getMessage());
        }
    }
}
