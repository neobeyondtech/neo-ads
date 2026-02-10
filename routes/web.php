<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\PembayaranController;
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
        Route::get('/', [PembayaranController::class, 'index'])->name('my-payment.index');
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
            Route::get('/', [PembayaranController::class, 'index'])->name('index');
    });

    Route::prefix('profile')
        ->name('profile.')
        ->controller(AccountController::class)
        ->group(function () {
            Route::post('/photo', 'updatePhoto')->name('update-photo');
            Route::get('/change-password', 'index')->name('index');
            Route::post('/change-password', 'update')->name('update-password');
        });
});