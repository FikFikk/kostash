<?php

use App\Http\Controllers\{
    AuthController,
    DashboardController,
    GalleryController,
    GlobalSettingController,
    MeterController,
    PublicController,
    ReportController,
    ReportResponseController,
    RoomController,
    SocialAuthController,
    TransactionController,
    UserController,
};

use App\Http\Controllers\Tenants\{
    PaymentController,
    PaymentHistoryController,
    ProfileController,
    TenantDashboardController,
};

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicController::class, 'index'])->name('public.home');

// Login alias route untuk compatibility
Route::redirect('/login', '/auth/login')->name('login');

/*
|--------------------------------------------------------------------------
| Social Authentication Routes
|--------------------------------------------------------------------------
*/
Route::prefix('auth/{provider}')->name('social.')->group(function () {
    Route::get('/redirect', [SocialAuthController::class, 'redirectToProvider'])->name('redirect');
    Route::get('/callback', [SocialAuthController::class, 'handleProviderCallback'])->name('callback');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::controller(AuthController::class)->name('auth.')->prefix('auth')->group(function () {
    // Guest only routes
    Route::middleware('guest')->group(function () {
        Route::get('login', 'login')->name('login');
        Route::post('login', 'login_process')->name('login.process');
        Route::get('register', 'register')->name('register');
        Route::post('register', 'register_process')->name('register.process');
    });

    // Authenticated routes
    Route::middleware('auth')->group(function () {
        Route::get('logout', 'logout_process')->name('logout');
    });

    // Logout page (accessible by all)
    Route::view('logout-page', 'auth.logout')->name('logout.page');
});

/*
|--------------------------------------------------------------------------
| Admin Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');

    // Room Management
    Route::prefix('room')->name('room.')->controller(RoomController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{room}', 'destroy')->name('destroy');
        Route::post('/temp-upload', 'tempUpload')->name('upload');
    });

    // Global Settings
    Route::prefix('global')->name('global.')->controller(GlobalSettingController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
    });

    // Gallery Management
    Route::prefix('gallery')->name('gallery.')->controller(GalleryController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{gallery}/edit', 'edit')->name('edit');
        Route::put('/{gallery}', 'update')->name('update');
        Route::delete('/{gallery}', 'destroy')->name('destroy');
    });

    // Meter Management
    Route::prefix('meter')->name('meter.')->controller(MeterController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
        
        // AJAX routes with constraints
        Route::get('/{meter:uuid}/details', 'getMeterDetails')->name('details');
        Route::get('/room/{room:uuid}/details', 'getRoomDetails')->name('room.details');
    });

    // Report Management
    Route::prefix('report')->name('report.')->group(function () {
        Route::controller(ReportController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/statistics', 'statistics')->name('statistics');
            Route::get('/{report}', 'show')->name('show');
            Route::put('/{report}/status', 'updateStatus')->name('updateStatus');
            Route::delete('/{report}', 'destroy')->name('destroy');
        });

        // Report Response Management
        Route::controller(ReportResponseController::class)->name('response.')->group(function () {
            Route::post('/{report}/response', 'store')->name('store');
            Route::put('/response/{response}', 'update')->name('update');
            Route::delete('/response/{response}', 'destroy')->name('destroy');
        });
    });

    // Transaction Management
    Route::get('transaction', [TransactionController::class, 'index'])->name('transaction.index');

    // User Management
    Route::prefix('user')->name('user.')->controller(UserController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}', 'show')->name('show');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });
});

/*
|--------------------------------------------------------------------------
| Tenant Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:tenants'])->prefix('tenant')->name('tenant.')->group(function () {
    Route::controller(TenantDashboardController::class)->group(function () {
        Route::get('/', 'index')->name('home');
        Route::get('/export', 'exportInvoice')->name('export');
    });

    // Payment Token (AJAX)
    Route::get('/payment/token', [PaymentController::class, 'getSnapToken'])->name('getSnapToken');

    // Profile Management
    Route::prefix('profile')->name('profile.')->controller(ProfileController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/edit', 'edit')->name('edit');
        Route::put('/', 'update')->name('update');
        Route::get('/change-password', 'changePasswordForm')->name('change-password');
        Route::post('/change-password', 'changePassword')->name('change-password.process');
    });

    // Report Management (Tenant)
    Route::prefix('report')->name('report.')->controller(ReportController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{report}', 'show')->name('show');
        Route::delete('/{report}', 'destroy')->name('destroy');
    });

    // Payment History
    Route::get('history', [PaymentHistoryController::class, 'index'])->name('history.index');
});
