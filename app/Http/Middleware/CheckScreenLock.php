<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckScreenLock
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && session('screen_locked')) {
            if (!$request->routeIs('auth.lock.screen') && !$request->routeIs('auth.unlock.process')) {

                // Log::warning('Unauthorized access attempt to locked screen', [
                //     'user_id' => auth()->id(),
                //     'ip_address' => $request->ip(),
                //     'attempted_url' => $request->fullUrl(),
                //     'user_agent' => $request->userAgent(),
                //     'timestamp' => now()
                // ]);
                
                session()->flash('warning', 'Akses ditolak. Layar sedang terkunci. Silakan unlock terlebih dahulu.');
                
                return redirect()->route('auth.lock.screen');
            }
        }

        return $next($request);
    }
}
