<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\GlobalSetting;
use Illuminate\Support\Facades\Auth;

// Quick login routes for testing
Route::get('/quick-admin', function () {
    $admin = User::where('role', 'admin')->first();
    if ($admin) {
        Auth::login($admin);
        return redirect('/dashboard');
    }
    return "No admin user found";
});

Route::get('/quick-tenant', function () {
    $tenant = User::where('role', 'tenants')->first();
    if ($tenant) {
        Auth::login($tenant);
        return redirect('/tenant');
    }
    return "No tenant user found";
});

Route::get('/setup-mayar', function () {
    $setting = GlobalSetting::first();
    if ($setting) {
        // Set dummy API key for testing - user should replace with real one
        $setting->update([
            'mayar_api_key' => 'your-real-api-key-here',
            'mayar_sandbox' => true,
            'mayar_redirect_url' => url('/payment/success'),
            'payment_type' => 'mayar'
        ]);
        return "Mayar settings updated. Please replace 'your-real-api-key-here' with actual Mayar API key.";
    }
    return "No global settings found";
});

Route::get('/debug-payment', function () {
    return view('debug-payment');
});

Route::get('/test-payment-simple', function () {
    return view('test-payment');
});
