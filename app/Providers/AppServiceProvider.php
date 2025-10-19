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
            $currentPath = $request->path();
            $currentUrl = $request->url();

            // Log semua request untuk debugging
            Log::info('Request incoming', [
                'path' => $currentPath,
                'url' => $currentUrl,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'referer' => $request->header('referer')
            ]);

            // Skip tracking untuk route yang bukan public/landing page
            $skipStarts = [
                'dashboard',
                'tenant',
                'auth',
                'artisan',
                'api',
            ];

            foreach ($skipStarts as $skip) {
                if (str_starts_with($currentPath, $skip)) {
                    Log::info('Skipping tracking - matched skip prefix', ['prefix' => $skip, 'path' => $currentPath]);
                    return;
                }
            }

            // Treat asset/storage/build/assets requests specially: skip them when the referer is internal (same host)
            // but allow them to create a visit when the referer is external (for example, Android app referrals or Google Maps)
            $assetPrefixes = ['storage', 'uploads', 'assets', 'build'];
            foreach ($assetPrefixes as $ap) {
                if (str_starts_with($currentPath, $ap)) {
                    $referer = $request->header('referer');
                    $isInternalReferer = false;
                    if ($referer) {
                        $refererHost = parse_url($referer, PHP_URL_HOST);
                        $appHost = parse_url(config('app.url') ?? $request->getSchemeAndHttpHost(), PHP_URL_HOST);
                        if ($refererHost && $appHost && $refererHost === $appHost) {
                            $isInternalReferer = true;
                        }
                    }

                    if ($isInternalReferer) {
                        Log::info('Skipping tracking - internal asset request', ['path' => $currentPath, 'referer' => $referer]);
                        return;
                    }

                    // if referer is null or external, allow further processing so first-party hits coming from external apps
                    // (eg. android-app://com.google...) can be counted as a landing.
                    Log::info('Asset request with external/empty referer - will consider for tracking', ['path' => $currentPath, 'referer' => $referer]);
                    break;
                }
            }

            if ($request->ajax() || $currentPath === 'favicon.ico') {
                Log::info('Skipping tracking - AJAX or favicon');
                return;
            }

            // Normalize IP (handle IPv6 loopback and proxies if needed)
            $ip = $request->ip();
            if ($ip === '::1' || $ip === '127.0.0.1') {
                // in local dev use server REMOTE_ADDR when available
                $serverIp = $request->server('REMOTE_ADDR');
                if ($serverIp && $serverIp !== $ip) {
                    $ip = $serverIp;
                }
            }
            $userId = Auth::id();
            $date = now()->toDateString();
            $url = $request->fullUrl();
            $userAgent = $request->userAgent();
            $referer = $request->header('referer'); // Bisa dari Google Maps, Facebook, dll

            // Visitor ID via cookie (more reliable than IP for mobile devices)
            $visitorId = $request->cookie('visitor_id');
            if (!$visitorId) {
                $visitorId = (string) \Illuminate\Support\Str::uuid();
                // queue cookie so it's set in response
                cookie()->queue(cookie()->forever('visitor_id', $visitorId));
                Log::info('Assigned new visitor_id cookie', ['visitor_id' => $visitorId]);
            }

            // Cek apakah sudah ada kunjungan hari ini dari visitor_id atau ip
            $query = Visit::where('date', $date)->where(function ($q) use ($visitorId, $ip) {
                if ($visitorId) {
                    $q->where('visitor_id', $visitorId);
                }
                $q->orWhere('ip', $ip);
            });

            $exists = $query->exists();

            if (!$exists) {
                $visit = Visit::create([
                    'ip' => $ip,
                    'user_id' => $userId,
                    'visitor_id' => $visitorId,
                    'date' => $date,
                    'url' => $url,
                    'user_agent' => $userAgent,
                    'referer' => $referer
                ]);

                Log::info('✅ Visitor tracked successfully!', [
                    'id' => $visit->id,
                    'visitor_id' => $visitorId,
                    'ip' => $ip,
                    'url' => $url,
                    'user_agent' => $userAgent,
                    'referer' => $referer
                ]);
            } else {
                Log::info('Visitor already tracked today', ['visitor_id' => $visitorId, 'ip' => $ip, 'date' => $date]);
            }
        } catch (\Exception $e) {
            // Log error detail untuk debugging
            Log::error('❌ Visitor tracking failed!', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}
