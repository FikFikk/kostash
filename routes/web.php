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
    Route::middleware('guest')->group(function () {
        Route::get('login', 'login')->name('login');
        Route::post('login', 'login_process')->name('login.process');
        Route::get('register', 'register')->name('register');
        Route::post('register', 'register_process')->name('register.process');
    });

    Route::middleware('auth')->group(function () {
        Route::get('logout', 'logout_process')->name('logout');
        Route::get('lock-screen', 'lock_screen')->name('lock.screen');
        Route::post('unlock', 'unlock_process')->name('unlock.process');
    });

    Route::view('logout-page', 'auth.logout')->name('logout.page');
});

/*
|--------------------------------------------------------------------------
| Admin Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin', 'check.screen.lock'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');

    // Resource Routes
    Route::resource('room', RoomController::class);
    Route::resource('gallery', GalleryController::class);
    Route::resource('meter', MeterController::class)->except(['show']);
    Route::resource('user', UserController::class);

    // Global Settings - Resource with only index, edit, update
    Route::resource('global', GlobalSettingController::class)->only(['index', 'edit', 'update']);

    // Meter additional routes
    Route::prefix('meter')->name('meter.')->group(function () {
        Route::get('/{meter:uuid}/details', [MeterController::class, 'getMeterDetails'])->name('details');
        Route::get('/room/{room:uuid}/details', [MeterController::class, 'getRoomDetails'])->name('room.details');
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

        // Report Response - Resource with store, update, destroy
        Route::resource('{report}/response', ReportResponseController::class)->only(['store', 'update', 'destroy'])->parameters([
            'response' => 'response'
        ]);
    });

    // Transaction Management
    Route::resource('transaction', TransactionController::class)->only(['index']);
});

/*
|--------------------------------------------------------------------------
| Tenant Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:tenants'])->prefix('tenant')->name('tenant.')->group(function () {
    // Dashboard
    Route::controller(TenantDashboardController::class)->group(function () {
        Route::get('/', 'index')->name('home');
        Route::get('/export', 'exportInvoice')->name('export');
    });

    // Payment Token (AJAX)
    Route::get('/payment/token', [PaymentController::class, 'getSnapToken'])->name('getSnapToken');

    // Profile Management - Custom resource-like structure
    Route::prefix('profile')->name('profile.')->controller(ProfileController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/edit', 'edit')->name('edit');
        Route::put('/', 'update')->name('update');
        Route::get('/change-password', 'changePasswordForm')->name('change-password');
        Route::post('/change-password', 'changePassword')->name('change-password.process');
    });

    // Report Management - Resource with index, create, store, show, destroy
    Route::resource('report', ReportController::class)->only(['index', 'create', 'store', 'show', 'destroy']);

    // Payment History - Resource with only index
    Route::resource('history', PaymentHistoryController::class)->only(['index']);
});