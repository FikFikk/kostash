<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

Route::controller(PublicController::class)->name('public.')->group(function () {
    Route::get('/', 'index')->name('home');
});

Route::controller(AuthController::class)->name('auth.')->prefix('auth')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', 'login')->name('login');
        Route::post('login', 'login_process')->name('login.process');
        Route::get('register', 'register')->name('register');

    });

    Route::middleware('auth')->group(function () {
        Route::get('logout', 'logout_process')->name('logout');
    });
});