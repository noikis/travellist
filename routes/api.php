<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Auth routes
Route::prefix('User')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware(['auth:sanctum'])->post('/logout', [AuthController::class, 'logout']);
});

