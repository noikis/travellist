<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Auth routes
Route::prefix('User')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::middleware(['auth:sanctum'])->post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::middleware(['auth:sanctum'])->post('/refresh', [AuthController::class, 'refresh'])->name('refresh_token');
});

