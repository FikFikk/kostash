<?php

use App\Services\MayarService;
use Illuminate\Support\Facades\Route;

// Test route untuk memastikan server berfungsi
Route::get('/test-simple', function () {
    return "<h1>Server is working! Current time: " . now() . "</h1>";
});

// Test route untuk debug Mayar payment
Route::get('/test-mayar', function () {
    try {
        $mayarService = new MayarService();

        $params = $mayarService->buildPaymentParams(
            'TEST-' . time(),
            50000,
            'Test Payment untuk debugging',
            'Test User',
            'test@example.com',
            '08123456789'
        );

        echo "<h2>Mayar Test Payment</h2>";
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
