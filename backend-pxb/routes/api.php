<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Connect controllers / Подключаем контроллеры

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;

// Routes for all users / Маршруты для всех пользователей

Route::get('/courses', [CourseController::class, 'getAllCourses']);
Route::get('/courses/{id}', [CourseController::class, 'getCourseDetail']);

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

// Routes for authenticated users / Маршруты для авторизованных пользователей

Route::middleware('auth:sanctum')->group(function () {
    // Route for logout / Маршрут для выхода
    Route::post('/logout', [AuthController::class, 'logout']);

});