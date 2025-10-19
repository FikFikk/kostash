
<?php

use App\Http\Controllers\{
    AuthController,
    DashboardController,
    EventController,
    GalleryController,
    GlobalSettingController,
    MeterController,
    NotificationController,
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
    CalendarController as TenantCalendarController,
};

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Artisan;
/*
|--------------------------------------------------------------------------
| Maintenance & Artisan Command Routes (Admin Only)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->prefix('artisan')->group(function () {
    Route::get('/migrate', function () {
        Artisan::call('migrate');
        return 'Migrate executed!';
    });
    Route::get('/optimize', function () {
        Artisan::call('optimize');
        return 'Optimize executed!';
    });
    Route::get('/route-cache', function () {
        Artisan::call('route:cache');
        return 'Route cache executed!';
    });
    Route::get('/config-cache', function () {
        Artisan::call('config:cache');
        return 'Config cache executed!';
    });
    Route::get('/view-cache', function () {
        Artisan::call('view:cache');
        return 'View cache executed!';
    });
    Route::get('/clear', function () {
        Artisan::call('optimize:clear');
        return 'Optimize clear executed!';
    });
});
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
        Route::get('/{meter}/export', [MeterController::class, 'export'])->name('export');
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

    // Notification Management
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'adminIndex'])->name('index');
        Route::get('/data', [NotificationController::class, 'adminData'])->name('data');
    });

    // Calendar Management
    Route::prefix('calendar')->name('calendar.')->group(function () {
        Route::controller(\App\Http\Controllers\EventController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/events', 'getEvents')->name('events.get');
            Route::post('/events', 'store')->name('events.store');
            Route::get('/events/{event}', 'show')->name('events.show');
            Route::put('/events/{event}', 'update')->name('events.update');
            Route::delete('/events/{event}', 'destroy')->name('events.destroy');
            Route::put('/events/{event}/datetime', 'updateDateTime')->name('events.updateDateTime');
            Route::get('/types', 'getEventTypes')->name('types');
            Route::get('/statistics', 'getStatistics')->name('statistics');
        });
    });
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

    // Tenant can respond to their own report
    Route::post('report/{report}/response', [\App\Http\Controllers\ReportResponseController::class, 'tenantStore'])->name('report.response.store');
    // Tenant can update their own response
    Route::put('report/{report}/response/{response}', [\App\Http\Controllers\ReportResponseController::class, 'update'])->name('report.response.update');

    // Payment History - Resource with only index
    Route::resource('history', PaymentHistoryController::class)->only(['index']);

    // Notification Management
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'tenantIndex'])->name('index');
        Route::get('/data', [NotificationController::class, 'tenantData'])->name('data');
    });

    // Calendar Management (limited access for tenants)
    Route::prefix('calendar')->name('calendar.')->group(function () {
        Route::controller(TenantCalendarController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/events', 'getEvents')->name('events.get');
            Route::post('/events', 'store')->name('events.store');
            Route::get('/events/{event}', 'show')->name('events.show');
            Route::put('/events/{event}', 'update')->name('events.update');
            Route::delete('/events/{event}', 'destroy')->name('events.destroy');
            Route::put('/events/{event}/datetime', 'updateDateTime')->name('events.updateDateTime');
            Route::get('/statistics', 'getStatistics')->name('statistics');
        });
    });
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

/*
|--------------------------------------------------------------------------
| Notification Routes (Simple Routes)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('notifications')->name('notifications.')->group(function () {
    Route::post('/{notification}/read', [NotificationController::class, 'markAsRead'])->name('read');
    Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
    Route::delete('/{notification}', [NotificationController::class, 'destroy'])->name('destroy');
});

/*
|--------------------------------------------------------------------------
| Notification Routes (AJAX)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('notifications')->name('notifications.')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('index');
    Route::post('/{notification}/read', [NotificationController::class, 'markAsRead'])->name('read');
    Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
    Route::delete('/{notification}', [NotificationController::class, 'destroy'])->name('destroy');
    Route::get('/unread-count', [NotificationController::class, 'unreadCount'])->name('unread-count');
});
