<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\GlobalSetting;
use App\Services\MayarService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// Simple test page
Route::get('/test-payment-final', function () {
    return view('test-payment-final');
});

// Set Mayar API key for testing
Route::get('/set-mayar-key/{key}', function ($key) {
    $settings = GlobalSetting::first();
    if (!$settings) {
        $settings = new GlobalSetting();
    }

    $settings->update([
        'mayar_api_key' => $key,
        'mayar_sandbox' => true,
        'mayar_redirect_url' => url('/payment/success'),
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Mayar API key updated successfully',
        'key' => substr($key, 0, 8) . '...' // Show only first 8 chars for security
    ]);
});

// Simple direct test route for Mayar payment
Route::post('/test-mayar-direct', function (Request $request) {
    try {
        // Check if we have settings
        $settings = GlobalSetting::first();
        if (!$settings) {
            return response()->json(['error' => 'No global settings found. Visit /set-mayar-key/{your-api-key} first'], 500);
        }

        if (!$settings->mayar_api_key || $settings->mayar_api_key === 'test-key') {
            return response()->json(['error' => 'Please set real Mayar API key via /set-mayar-key/{your-api-key}'], 500);
        }

        $mayarService = new MayarService();

        $params = $mayarService->buildPaymentParams(
            'TEST-' . time(),
            50000,
            'Test pembayaran dari debugging',
            'Test User',
            'test@example.com',
            '08123456789'
        );

        $response = $mayarService->createPaymentRequest($params);
        $paymentUrl = $mayarService->getPaymentUrl($response);

        return response()->json([
            'success' => true,
            'payment_url' => $paymentUrl,
            'params' => $params,
            'response' => $response
        ]);
    } catch (Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
});

// Test route to check route
Route::get('/test-routes', function () {
    $routes = collect(Route::getRoutes())->filter(function ($route) {
        return str_contains($route->getName() ?? '', 'tenant');
    })->map(function ($route) {
        return [
            'name' => $route->getName(),
            'uri' => $route->uri(),
            'methods' => $route->methods()
        ];
    });

    return response()->json($routes);
});
