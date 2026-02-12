<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\Api\JwtAuthController;

// Public authentication routes (no JWT required)
Route::prefix('auth')
    ->group(function () {
        Route::post('/register', [JwtAuthController::class, 'register']);
        Route::post('/login', [JwtAuthController::class, 'login']);
        Route::post('/refresh', [JwtAuthController::class, 'refresh']);
    });

// Protected routes (JWT required)
Route::prefix('auth')
    ->middleware('jwt')
    ->group(function () {
        Route::get('/profile', [JwtAuthController::class, 'profile']);
        Route::post('/logout', [JwtAuthController::class, 'logout']);
    });

    

Route::prefix('locations')
    ->controller(LocationController::class)
    ->middleware('throttle:60,1')
    ->group(function () {
        Route::get('/provinces', 'provinces');
        Route::get('/cities', 'cities');
        Route::get('/districts', 'districts');
        Route::get('/subdistricts', 'subdistricts');
    });