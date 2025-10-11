<?php

namespace App\Http\Controllers;

use App\Models\GlobalSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GlobalSettingController extends Controller
{
    public function index()
    {
        $global = $this->getSetting();
        return view('dashboard.admin.global.index', compact('global'));
    }

    public function edit()
    {
        $global = $this->getSetting();
        return view('dashboard.admin.global.edit', compact('global'));
    }

    public function update(Request $request)
    {
        $validated = $this->validateSettings($request);

        $this->getSetting()->update($validated);

        return redirect()
            ->route('dashboard.global.index')
            ->with('success', 'Global settings berhasil diperbarui.');
    }

    // DRY Helper Methods
    protected function getSetting()
    {
        return GlobalSetting::firstOrFail(); // fallback jika tidak ada
    }

    protected function validateSettings(Request $request)
    {
        return $request->validate([
            // Pricing & Bills
            'monthly_room_price' => 'required|integer|min:0',
            'water_price' => 'required|integer|min:0',
            'electric_price' => 'required|integer|min:0',
            'deposit_amount' => 'nullable|integer|min:0',
            'late_fee_percentage' => 'nullable|numeric|min:0|max:100',
            'admin_fee' => 'nullable|integer|min:0',

            // OAuth & Social Login
            'google_client_id' => 'nullable|string|max:255',
            'google_client_secret' => 'nullable|string|max:255',
            'google_redirect_uri' => 'nullable|url|max:255',
            'facebook_client_id' => 'nullable|string|max:255',
            'facebook_client_secret' => 'nullable|string|max:255',
            'facebook_redirect_uri' => 'nullable|url|max:255',
            'twitter_client_id' => 'nullable|string|max:255',
            'twitter_client_secret' => 'nullable|string|max:255',
            'twitter_redirect_uri' => 'nullable|url|max:255',

            // Payment Gateway - Mayar
            'mayar_api_key' => 'nullable|string',
            'mayar_webhook_token' => 'nullable|string|max:255',
            'mayar_redirect_url' => 'nullable|url|max:255',
            'mayar_sandbox' => 'nullable|boolean',
            'is_production' => 'nullable|boolean',
            'payment_type' => 'nullable|string|max:255',

            // Email & SMTP
            'email_host' => 'nullable|string|max:255',
            'email_port' => 'nullable|integer|min:1|max:65535',
            'email_username' => 'nullable|string|max:255',
            'email_password' => 'nullable|string|max:255',
            'email_encryption' => 'nullable|string|in:ssl,tls',
            'email_from_address' => 'nullable|email|max:255',
            'email_from_name' => 'nullable|string|max:255',

            // SEO Settings
            'site_title' => 'nullable|string|max:255',
            'site_keywords' => 'nullable|string',
            'site_description' => 'nullable|string',
            'meta_author' => 'nullable|string|max:255',
            'meta_robots' => 'nullable|string|max:255',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string',
            'og_image' => 'nullable|url|max:255',

            // General Info
            'app_name' => 'nullable|string|max:255',
            'app_logo' => 'nullable|string|max:255',
            'kost_address' => 'nullable|string',
            'kost_phone' => 'nullable|string|max:20',
            'kost_email' => 'nullable|email|max:255',
            'description' => 'nullable|string',
            'timezone' => 'nullable|string|max:255',
        ]);
    }
}
