<?php

use App\Http\Controllers\{
    AuthController,
    DashboardController,
    GalleryController,
    GlobalSettingController,
    MeterController,
    PublicController,
    RoomController,
    SocialAuthController,
    UserController,
};

use App\Http\Controllers\Tenants\TenantDashboardController;
use App\Http\Controllers\Tenants\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

Route::controller(PublicController::class)->name('public.')->group(function () {
    Route::get('/', 'index')->name('home');
});

// Alias route 'login' supaya tidak error
Route::get('login', function () {
    return Redirect::route('auth.login');
})->name('login');

Route::get('/auth/{provider}/redirect', [SocialAuthController::class, 'redirectToProvider'])->name('social.redirect');
Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback'])->name('social.callback');

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

// -----------------------------
// Admin Dashboard Route
// -----------------------------
Route::middleware(['auth', 'role:admin'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');

    Route::prefix('room')->name('room.')->group(function () {
        Route::controller(RoomController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/destroy/{room}', 'destroy')->name('destroy');
            Route::post('/rooms/temp-upload', 'tempUpload')->name('upload');
        });
    });

    Route::prefix('global')->name('global.')->group(function () {
        Route::controller(GlobalSettingController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
        });
    });

    Route::prefix('gallery')->name('gallery.')->group(function () {
        Route::controller(GalleryController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{gallery}', 'edit')->name('edit');
            Route::put('/update/{gallery}', 'update')->name('update');
            Route::delete('/destroy/{gallery}', 'destroy')->name('destroy');
        });
    });

    Route::prefix('meter')->name('meter.')->group(function () {
        Route::controller(MeterController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        });
    });

    Route::prefix('user')->name('user.')->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/destroy/{id}', 'destroy')->name('destroy');
            Route::get('/show/{id}', 'show')->name('show');
        });
    });
});

// -----------------------------
// Tenant Dashboard Route
// -----------------------------
Route::middleware(['auth', 'role:tenants'])->prefix('tenant')->name('tenant.')->group(function () {
    Route::get('/', [TenantDashboardController::class, 'index'])->name('home');
    Route::get('/export', [TenantDashboardController::class, 'exportInvoice'])->name('export');

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::controller(ProfileController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/edit', 'edit')->name('edit');
            Route::put('/update', 'update')->name('update');
            Route::get('/change-password', 'changePasswordForm')->name('change-password');
            Route::post('/change-password', 'changePassword')->name('change-password');
        });
    });

    // Tambahkan fitur lainnya khusus tenant di sini nanti
    // Route::get('/bills', [TenantBillController::class, 'index'])->name('bills');
});
