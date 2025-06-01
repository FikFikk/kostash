<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Midtrans Configuration
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for Midtrans.
    | You should store your client key and server key in your .env file.
    |
    */

    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'server_key' => env('MIDTRANS_SERVER_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Midtrans Environment
    |--------------------------------------------------------------------------
    |
    | Set to true if you are using the Midtrans production environment.
    | Set to false if you are using the Midtrans sandbox environment.
    |
    */
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false), // Default ke sandbox jika tidak diset

    /*
    |--------------------------------------------------------------------------
    | Midtrans Sanitized
    |--------------------------------------------------------------------------
    |
    | Set to true if you want Midtrans to sanitize the request data.
    |
    */
    'is_sanitized' => env('MIDTRANS_IS_SANITIZED', true),

    /*
    |--------------------------------------------------------------------------
    | Midtrans 3DS
    |--------------------------------------------------------------------------
    |
    | Set to true if you want to enable 3D Secure for credit card transactions.
    |
    */
    'is_3ds' => env('MIDTRANS_IS_3DS', true),

    /*
    | Optional: Override notification URLs
    | Uncomment and set these if you need to override the default notification URLs
    | configured in your Midtrans dashboard.
    */
    // 'notification_url' => env('MIDTRANS_NOTIFICATION_URL'),
    // 'finish_redirect_url' => env('MIDTRANS_FINISH_REDIRECT_URL'),
    // 'unfinish_redirect_url' => env('MIDTRANS_UNFINISH_REDIRECT_URL'),
    // 'error_redirect_url' => env('MIDTRANS_ERROR_REDIRECT_URL'),
];