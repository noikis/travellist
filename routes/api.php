<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


// Auth routes
Route::post('/User/register', [AuthController::class, 'register']);
