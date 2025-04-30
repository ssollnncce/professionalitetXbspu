<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Connect controllers / Подключаем контроллеры

use App\Http\Controllers\AuthController;

// Routes for guest / Маршруты для гостей

Route::middleware('guest')->group(function () {

    // Route for login / Маршрут для авторизации
    Route::post('/login', [AuthController::class, 'login']);
    // Route for registration / Маршрут для регистрации
    Route::post('/register', [AuthController::class, 'register']);

    // Route for password reset / Маршрут для сброса пароля
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
});

Route::middleware('auth:sanctum')->group(function () {
    // Route for logout / Маршрут для выхода
    Route::post('/logout', [AuthController::class, 'logout']);
    
});