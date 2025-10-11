<?php

use App\Services\MayarService;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Meter;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Payments\MayarController;

// Test route untuk debug Mayar payment dengan endpoint baru
Route::get('/test-mayar-new', function () {
    try {
        $mayarService = new MayarService();

        $params = $mayarService->buildPaymentParams(
            'TEST-' . time(),
            50000,
            'Test Payment untuk debugging endpoint baru',
            'Test User',
            'test@example.com',
            '08123456789'
        );

        echo "<h2>Mayar Test Payment (Endpoint Baru)</h2>";
        echo "<h3>Request Parameters:</h3>";
        echo "<pre>" . json_encode($params, JSON_PRETTY_PRINT) . "</pre>";

        $response = $mayarService->createPaymentRequest($params);

        echo "<h3>Mayar Response:</h3>";
        echo "<pre>" . json_encode($response, JSON_PRETTY_PRINT) . "</pre>";

        $paymentUrl = $mayarService->getPaymentUrl($response);

        echo "<h3>Payment URL:</h3>";
        echo "<a href='{$paymentUrl}' target='_blank'>{$paymentUrl}</a>";
    } catch (Exception $e) {
        echo "<h2>Error:</h2>";
        echo "<pre style='color: red;'>" . $e->getMessage() . "</pre>";
        echo "<h3>Stack Trace:</h3>";
        echo "<pre style='color: red;'>" . $e->getTraceAsString() . "</pre>";
    }
});

// Test route untuk login sebagai tenant dan test payment
Route::get('/test-tenant-login', function () {
    $tenant = User::where('role', 'tenants')->first();
    if ($tenant) {
        Auth::login($tenant);
        return redirect('/tenant');
    } else {
        return "No tenant users found";
    }
});

// Test route untuk direct payment create
Route::get('/test-tenant-payment', function () {
    try {
        $tenant = User::where('role', 'tenants')->first();
        Auth::login($tenant);

        // Get tenant's meter
        $meter = Meter::where('room_id', $tenant->room_id)->first();

        if (!$meter) {
            return "No meter found for tenant";
        }

        echo "<h2>Testing Tenant Payment Creation</h2>";
        echo "<p>Tenant: {$tenant->name} (Room: {$tenant->room_id})</p>";
        echo "<p>Meter ID: {$meter->id}</p>";

        // Simulate the payment request dengan dependency injection
        $mayarService = new MayarService();
        $mayarController = new MayarController($mayarService);

        $request = new \Illuminate\Http\Request();
        $request->merge([
            'meter_id' => $meter->id,
            'payment_method' => 'mayar'
        ]);
        $response = $mayarController->createPayment($request);

        echo "<h3>Payment Response:</h3>";
        echo "<pre>" . json_encode($response->getData(), JSON_PRETTY_PRINT) . "</pre>";
    } catch (Exception $e) {
        echo "<h2>Error:</h2>";
        echo "<pre style='color: red;'>" . $e->getMessage() . "</pre>";
        echo "<h3>Stack Trace:</h3>";
        echo "<pre style='color: red;'>" . $e->getTraceAsString() . "</pre>";
    }
});
