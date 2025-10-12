<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Payments\MidtransController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Midtrans webhook - no CSRF protection needed
// Route::post('/midtrans/callback', [MidtransController::class, 'handleNotification'])->name('api.midtrans.callback');
