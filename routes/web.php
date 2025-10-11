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

use App\Http\Controllers\Payments\MayarController;

use App\Http\Controllers\Tenants\{
    PaymentController,
    PaymentHistoryController,
    ProfileController,
    TenantDashboardController,
};

use Illuminate\Support\Facades\Route;

// Include quick login routes for testing
require __DIR__ . '/quick-login.php';

// Include final debug routes
require __DIR__ . '/debug-final.php';

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [PublicController::class, 'index'])->name('public.home');
Route::redirect('/login', '/auth/login')->name('login');

/*
|--------------------------------------------------------------------------
| Mayar Webhook Callback (No Auth Required)
|--------------------------------------------------------------------------
*/
Route::post('/mayar/webhook', [MayarController::class, 'handleWebhook'])->name('mayar.webhook');

// Payment return URLs
Route::get('/payment/success', [MayarController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/payment/pending', [MayarController::class, 'paymentPending'])->name('payment.pending');
Route::get('/payment/failed', [MayarController::class, 'paymentFailed'])->name('payment.failed');

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
        Route::post('login', 'loginProcess')->name('login.process');
        Route::get('register', 'register')->name('register');
        Route::post('register', 'registerProcess')->name('register.process');
    });

    Route::middleware('auth')->group(function () {
        Route::get('logout', 'logoutProcess')->name('logout');
        Route::get('lock-screen', 'lockScreen')->name('lock.screen');
        Route::post('unlock', 'unlockProcess')->name('unlock.process');
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

    // Global Settings - Custom routes (only one global setting record)
    Route::prefix('global')->name('global.')->group(function () {
        Route::get('/', [GlobalSettingController::class, 'index'])->name('index');
        Route::get('/edit', [GlobalSettingController::class, 'edit'])->name('edit');
        Route::put('/update', [GlobalSettingController::class, 'update'])->name('update');
    });

    // Meter additional routes
    Route::prefix('meter')->name('meter.')->group(function () {
        Route::get('/{meter:uuid}/details', [MeterController::class, 'getMeterDetails'])->name('details');
        Route::get('/room/{room:uuid}/details', [MeterController::class, 'getRoomDetails'])->name('room.details');
    });

    // Room additional routes
    Route::prefix('room')->name('room.')->group(function () {
        Route::patch('{room}/vacate', [RoomController::class, 'vacate'])->name('vacate');
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
        Route::get('/receipt/{transaction}', 'downloadReceipt')->name('download.receipt');
    });

    // Payment Routes
    Route::post('/payment/create', [PaymentController::class, 'createPayment'])->name('createPayment');
    Route::get('/payment/status/{orderId}', [PaymentController::class, 'getPaymentStatus'])->name('getPaymentStatus');

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

/*
|--------------------------------------------------------------------------
| Payment API Routes
|--------------------------------------------------------------------------
*/
// Mayar Payment Routes
Route::prefix('api/payments/mayar')->name('api.payments.mayar.')->group(function () {
    // Protected routes for authenticated users
    Route::middleware('auth')->group(function () {
        Route::post('/create', [MayarController::class, 'createPayment'])->name('create');
        Route::get('/status/{orderId}', [MayarController::class, 'getPaymentStatus'])->name('status');
    });
});

// API route for payment status check (used by JavaScript)
Route::get('/api/payment/status/{orderId}', [MayarController::class, 'getPaymentStatus'])->name('api.payment.status');
