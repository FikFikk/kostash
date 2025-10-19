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
     * Track visitor unik per hari berdasarkan IP (hanya untuk public/landing page)
     */
    protected function trackVisitor(): void
    {
        try {
            $request = request();
            $currentUrl = $request->url();

            // Hanya track jika akses ke landing page/public (bukan dashboard/admin/tenant)
            if (
                str_contains($currentUrl, '/dashboard') ||
                str_contains($currentUrl, '/tenant') ||
                str_contains($currentUrl, '/auth') ||
                str_contains($currentUrl, '/artisan')
            ) {
                return;
            }

            $ip = $request->ip();
            $userId = Auth::id();
            $date = now()->toDateString();
            $url = $request->fullUrl();
            $userAgent = $request->userAgent();
            $referer = $request->header('referer');

            // Cek apakah sudah ada kunjungan hari ini dari IP ini ke URL ini
            $exists = Visit::where('ip', $ip)
                ->where('date', $date)
                ->where('url', $url)
                ->exists();

            if (!$exists) {
                Visit::create([
                    'ip' => $ip,
                    'user_id' => $userId,
                    'date' => $date,
                    'url' => $url,
                    'user_agent' => $userAgent,
                    'referer' => $referer
                ]);
            }
        } catch (\Exception $e) {
            // Silent fail untuk tidak mengganggu aplikasi
            Log::error('Visitor tracking failed: ' . $e->getMessage());
        }
    }
}
