<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Connect controllers / Подключаем контроллеры

use App\Http\Controllers\AuthController;

// Authentification routes for guest (login, register) / Маршруты аутентификации для гостей (вход, регистрация)

Route::middleware('guest')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});
