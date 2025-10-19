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

            // Collect fetch headers and accept-language (we will store them in DB)
            $secFetchSite = $request->header('sec-fetch-site');
            $secFetchMode = $request->header('sec-fetch-mode');
            $secFetchUser = $request->header('sec-fetch-user');
            $acceptLanguage = $request->header('accept-language');

            // No request-level debug logging per your request. We will persist data to DB for every request.

            // Determine if this request looks like a top-level navigation (browser navigated/opened the URL)
            $isTopLevelNavigation = false;
            if ($secFetchMode && strtolower($secFetchMode) === 'navigate') {
                if ($secFetchUser === '?1') {
                    $isTopLevelNavigation = true;
                }
                if ($secFetchSite && in_array(strtolower($secFetchSite), ['none', 'cross-site'])) {
                    $isTopLevelNavigation = true;
                }
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
            $incomingVisitorCookie = $request->cookie('visitor_id');
            $visitorId = $incomingVisitorCookie;
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

            // Decide whether to force-create a Visit in cases where the incoming request had no cookie
            // but clearly looks like an external app navigation (android-app referer, sec-fetch navigation,
            // or Android user-agent with no referer). This helps capture arrivals from apps that don't
            // send cookies on their first request.
            $forceCreate = false;
            $referer = $referer ?? $request->header('referer');
            $ua = strtolower($userAgent ?? '');
            if (!$incomingVisitorCookie) {
                // android-app referer example: android-app://com.google.android.googlequicksearchbox/
                if ($referer && str_starts_with($referer, 'android-app://')) {
                    $forceCreate = true;
                }

                // sec-fetch navigation (top-level)
                if ($isTopLevelNavigation) {
                    $forceCreate = true;
                }

                // If no referer but UA looks like Android or Google app, consider forcing creation
                if (!$referer && (str_contains($ua, 'android') || str_contains($ua, 'googlequicksearchbox') || str_contains($ua, 'google'))) {
                    $forceCreate = true;
                }
            }

            // Always persist Visit row (force-create semantics requested)
            $headersJson = json_encode($request->headers->all());
            $visit = Visit::create([
                'ip' => $ip,
                'user_id' => $userId,
                'visitor_id' => $visitorId,
                'date' => $date,
                'url' => $url,
                'user_agent' => $userAgent,
                'referer' => $referer,
                'sec_fetch_site' => $secFetchSite,
                'sec_fetch_mode' => $secFetchMode,
                'sec_fetch_user' => $secFetchUser,
                'accept_language' => $acceptLanguage,
                'headers_json' => $headersJson,
            ]);
        } catch (\Exception $e) {
            // Log error detail untuk debugging
            Log::error('❌ Visitor tracking failed!', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}
