<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GlobalSetting extends Model
{
    protected $fillable = [
        // Pricing & Bills
        'monthly_room_price',
        'water_price',
        'electric_price',
        'deposit_amount',
        'late_fee_percentage',
        'admin_fee',

        // OAuth & Social Login
        'google_client_id',
        'google_client_secret',
        'google_redirect_uri',
        'facebook_client_id',
        'facebook_client_secret',
        'facebook_redirect_uri',
        'twitter_client_id',
        'twitter_client_secret',
        'twitter_redirect_uri',

        // Payment Gateway - Mayar
        'mayar_api_key',
        'mayar_webhook_token',
        'mayar_redirect_url',
        'mayar_sandbox',
        'is_production',
        'payment_type',

        // Email & SMTP
        'email_host',
        'email_port',
        'email_username',
        'email_password',
        'email_encryption',
        'email_from_address',
        'email_from_name',

        // SEO Settings
        'site_title',
        'site_keywords',
        'site_description',
        'meta_author',
        'meta_robots',
        'og_title',
        'og_description',
        'og_image',

        // General Info
        'app_name',
        'app_logo',
        'kost_address',
        'kost_phone',
        'kost_email',
        'description',
        'timezone',
    ];

    protected $casts = [
        'is_production' => 'boolean',
        'email_port' => 'integer',
        'monthly_room_price' => 'integer',
        'water_price' => 'integer',
        'electric_price' => 'integer',
        'deposit_amount' => 'integer',
        'late_fee_percentage' => 'decimal:2',
        'admin_fee' => 'integer',
    ];
}
