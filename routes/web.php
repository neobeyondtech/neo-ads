<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CustomerProfileController;
use App\Http\Controllers\AccountController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Models\User;

Route::get('/', [AuthController::class, 'showLogin'])->name('home');

// Rute untuk memproses form login
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

// Rute logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'reset'])->name('password.update');
Route::get('/email/verify', function () {
    return view('verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->name('verification.verify');
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('success', 'Link verifikasi telah dikirim ulang.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
Route::get('/register', function () {
    return view('register');
});
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/auth/google', [AuthController::class, 'redirectGoogle']);
Route::get('/auth/google/callback', [AuthController::class, 'callbackGoogle']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/my-dashboard', [DashboardController::class, 'index'])->name('my-dashboard');

    // Pembayaran Routes
    Route::prefix('my-payment')->group(function () { 
        Route::get('/', [TransactionController::class, 'index'])->name('my-payment.index');
    });

    // Iklan Routes
    Route::prefix('my-ads')
        ->name('my-ads.')
        ->group(function () {
        Route::get('/', [AdvertisementController::class, 'index'])->name('index');
        Route::get('/create', [AdvertisementController::class, 'create'])->name('create');
        Route::post('/store', [AdvertisementController::class, 'store'])->name('store');
        Route::get('/detail/{advertisement}', [AdvertisementController::class, 'show'])->name('show');
        Route::post('/calculate-price', [AdvertisementController::class, 'calculatePrice'])->name('calculate-price');
        Route::get('/cancel/{advertisement}', [AdvertisementController::class, 'cancelOrder'])->name('cancel');
    });
    
    // Customer Profile Routes
    Route::prefix('my-profile')
        ->name('my-profile.')
        ->controller(CustomerProfileController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::put('/update', 'update')->name('update');
            Route::put('/contact', 'updateContact')->name('update-contact');
        });

    //Monitoring
    Route::prefix('my-orders')
        ->name('my-orders.')
         ->group(function () {
            Route::get('/', [TransactionController::class, 'index'])->name('index');
    });

    Route::prefix('profile')
        ->name('profile.')
        ->controller(AccountController::class)
        ->group(function () {
            Route::post('/photo', 'updatePhoto')->name('update-photo');
            Route::get('/change-password', 'index')->name('index');
            Route::post('/change-password', 'update')->name('update-password');
        });

    // Admin Routes
    Route::prefix('admin')
        ->name('admin.')
        ->middleware(['auth', 'verified'])
        ->group(function () {
            Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
            
            // Advertisements
            Route::prefix('advertisements')
                ->name('advertisements.')
                ->controller(\App\Http\Controllers\Admin\AdvertisementController::class)
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/', 'store')->name('store');
                    Route::get('/{advertisement}', 'show')->name('show');
                    Route::get('/{advertisement}/edit', 'edit')->name('edit');
                    Route::put('/{advertisement}', 'update')->name('update');
                    Route::delete('/{advertisement}', 'destroy')->name('destroy');
                });

            // Customers
            Route::prefix('customers')
                ->name('customers.')
                ->controller(\App\Http\Controllers\Admin\CustomerController::class)
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/', 'store')->name('store');
                    Route::get('/{customer}', 'show')->name('show');
                    Route::get('/{customer}/edit', 'edit')->name('edit');
                    Route::put('/{customer}', 'update')->name('update');
                    Route::delete('/{customer}', 'destroy')->name('destroy');
                });

            
            Route::prefix('customer_types')
                ->name('customer_types.')
                ->controller(\App\Http\Controllers\Admin\CustomerTypeController::class)
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/', 'store')->name('store');
                    Route::get('/{customer_type}', 'show')->name('show');
                    Route::get('/{customer_type}/edit', 'edit')->name('edit');
                    Route::put('/{customer_type}', 'update')->name('update');
                    Route::delete('/{customer_type}', 'destroy')->name('destroy');
                });

            
            Route::prefix('customer_categories')
                ->name('customer_categories.')
                ->controller(\App\Http\Controllers\Admin\CustomerCategorieController::class)
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/', 'store')->name('store');
                    Route::get('/{customer_categorie}', 'show')->name('show');
                    Route::get('/{customer_categorie}/edit', 'edit')->name('edit');
                    Route::put('/{customer_categorie}', 'update')->name('update');
                    Route::delete('/{customer_categorie}', 'destroy')->name('destroy');
                });

            // Partners
            Route::prefix('partners')
                ->name('partners.')
                ->controller(\App\Http\Controllers\Admin\PartnerController::class)
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/', 'store')->name('store');
                    Route::get('/{partner}', 'show')->name('show');
                    Route::get('/{partner}/edit', 'edit')->name('edit');
                    Route::put('/{partner}', 'update')->name('update');
                    Route::delete('/{partner}', 'destroy')->name('destroy');
                });

            // Transactions
            Route::prefix('transactions')
                ->name('transactions.')
                ->controller(\App\Http\Controllers\Admin\TransactionController::class)
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/', 'store')->name('store');
                    Route::get('/{transaction}', 'show')->name('show');
                    Route::get('/{transaction}/edit', 'edit')->name('edit');
                    Route::put('/{transaction}', 'update')->name('update');
                    Route::delete('/{transaction}', 'destroy')->name('destroy');
                });

            // Users
            Route::prefix('users')
                ->name('users.')
                ->controller(\App\Http\Controllers\Admin\UserController::class)
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/', 'store')->name('store');
                    Route::get('/{user}', 'show')->name('show');
                    Route::get('/{user}/edit', 'edit')->name('edit');
                    Route::put('/{user}', 'update')->name('update');
                    Route::delete('/{user}', 'destroy')->name('destroy');
                });

            // Provinces
            Route::prefix('provinces')
                ->name('provinces.')
                ->controller(\App\Http\Controllers\Admin\ProvinceController::class)
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/', 'store')->name('store');
                    Route::get('/{province}/edit', 'edit')->name('edit');
                    Route::put('/{province}', 'update')->name('update');
                    Route::delete('/{province}', 'destroy')->name('destroy');
                });

            // Cities
            Route::prefix('cities')
                ->name('cities.')
                ->controller(\App\Http\Controllers\Admin\CityController::class)
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/', 'store')->name('store');
                    Route::get('/{city}/edit', 'edit')->name('edit');
                    Route::put('/{city}', 'update')->name('update');
                    Route::delete('/{city}', 'destroy')->name('destroy');
                });

            // Vehicle Brands
            Route::prefix('vehicle-brands')
                ->name('vehicle-brands.')
                ->controller(\App\Http\Controllers\Admin\VehicleBrandController::class)
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/', 'store')->name('store');
                    Route::get('/{brand}/edit', 'edit')->name('edit');
                    Route::put('/{brand}', 'update')->name('update');
                    Route::delete('/{brand}', 'destroy')->name('destroy');
                });

            // Banks
            Route::prefix('banks')
                ->name('banks.')
                ->controller(\App\Http\Controllers\Admin\BankController::class)
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/', 'store')->name('store');
                    Route::get('/{bank}/edit', 'edit')->name('edit');
                    Route::put('/{bank}', 'update')->name('update');
                    Route::delete('/{bank}', 'destroy')->name('destroy');
                });

            // Payouts
            Route::prefix('payouts')
                ->name('payouts.')
                ->controller(\App\Http\Controllers\Admin\PayoutController::class)
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/', 'store')->name('store');
                    Route::get('/{payout}', 'show')->name('show');
                    Route::get('/{payout}/edit', 'edit')->name('edit');
                    Route::put('/{payout}', 'update')->name('update');
                    Route::delete('/{payout}', 'destroy')->name('destroy');
                });

            // Enrollments
            Route::prefix('enrollments')
                ->name('enrollments.')
                ->controller(\App\Http\Controllers\Admin\EnrollmentController::class)
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/', 'store')->name('store');
                    Route::get('/{enrollment}', 'show')->name('show');
                    Route::get('/{enrollment}/edit', 'edit')->name('edit');
                    Route::put('/{enrollment}', 'update')->name('update');
                    Route::delete('/{enrollment}', 'destroy')->name('destroy');
                });

            // Reports
            Route::prefix('reports')
                ->name('reports.')
                ->controller(\App\Http\Controllers\Admin\ReportController::class)
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/', 'store')->name('store');
                    Route::get('/{report}', 'show')->name('show');
                    Route::get('/{report}/edit', 'edit')->name('edit');
                    Route::put('/{report}', 'update')->name('update');
                    Route::delete('/{report}', 'destroy')->name('destroy');
                });

            // Districts
            Route::prefix('districts')
                ->name('districts.')
                ->controller(\App\Http\Controllers\Admin\DistrictController::class)
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/', 'store')->name('store');
                    Route::get('/{district}/edit', 'edit')->name('edit');
                    Route::put('/{district}', 'update')->name('update');
                    Route::delete('/{district}', 'destroy')->name('destroy');
                });

            // Subdistricts
            Route::prefix('subdistricts')
                ->name('subdistricts.')
                ->controller(\App\Http\Controllers\Admin\SubdistrictController::class)
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/', 'store')->name('store');
                    Route::get('/{subdistrict}/edit', 'edit')->name('edit');
                    Route::put('/{subdistrict}', 'update')->name('update');
                    Route::delete('/{subdistrict}', 'destroy')->name('destroy');
                });

        });
});