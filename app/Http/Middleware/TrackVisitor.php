<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visit;
use Illuminate\Support\Facades\Auth;

class TrackVisitor
{
    public function handle(Request $request, Closure $next)
    {
        // Catat kunjungan unik per hari berdasarkan IP
        $ip = $request->ip();
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

        return $next($request);
    }
}
