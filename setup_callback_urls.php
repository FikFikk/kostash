<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\GlobalSetting;

echo "=== SETTING UP DEFAULT CALLBACK URLs ===\n\n";

$setting = GlobalSetting::first();

if ($setting) {
    // Setup default URLs for development
    $baseUrl = 'http://kostash.test'; // Change to your domain

    $setting->update([
        'payment_notification_url' => $baseUrl . '/midtrans/callback',
        'payment_finish_url' => $baseUrl . '/payment/success',
        'payment_unfinish_url' => $baseUrl . '/payment/pending',
        'payment_error_url' => $baseUrl . '/payment/failed'
    ]);

    echo "✓ Callback URLs updated successfully:\n";
    echo "  Notification URL: " . $setting->payment_notification_url . "\n";
    echo "  Finish URL: " . $setting->payment_finish_url . "\n";
    echo "  Unfinish URL: " . $setting->payment_unfinish_url . "\n";
    echo "  Error URL: " . $setting->payment_error_url . "\n";

    echo "\n🔧 NGROK SETUP REQUIRED:\n";
    echo "1. Install ngrok: https://ngrok.com/download\n";
    echo "2. Run: ngrok http 80\n";
    echo "3. Copy the https URL (e.g., https://abc123.ngrok.io)\n";
    echo "4. Update notification URL to: https://yourdomain.ngrok.io/midtrans/callback\n";
    echo "5. Set this URL in Midtrans dashboard\n";
} else {
    echo "✗ No global settings found\n";
}

echo "\n=== END SETUP ===\n";
