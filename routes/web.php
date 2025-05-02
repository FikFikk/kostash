<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SocialAuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

Route::controller(PublicController::class)->name('public.')->group(function () {
    Route::get('/', 'index')->name('home');
});

// Alias route 'login' supaya tidak error
Route::get('login', function () {
    return Redirect::route('auth.login');
})->name('login');

Route::get('auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);

Route::controller(AuthController::class)->name('auth.')->prefix('auth')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', 'login')->name('login');
        Route::post('login', 'login_process')->name('login.process');
        Route::get('register', 'register')->name('register');
        Route::post('register', 'register_process')->name('register.process');

    });

    Route::middleware('auth')->group(function () {
        Route::get('logout', 'logout_process')->name('logout');
    });

    Route::get('logout-page', function () {
        return view('auth.logout');
    })->name('logout.page');
});

Route::middleware('auth')->group(function () {
    Route::name('dashboard.')->prefix('dashboard')->group(function () {
        Route::controller(DashboardController::class)->group(function () {
            Route::get('/', 'index')->name('home');
        });

    });
    Route::name('room.')->prefix('room')->group(function () {
        Route::controller(RoomController::class)->group(function () {
            Route::get('/', 'index')->name('home');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/destroy/{room}', 'destroy')->name('destroy');
            Route::post('/rooms/temp-upload', [RoomController::class, 'tempUpload'])->name('upload');
        });

    });
});
