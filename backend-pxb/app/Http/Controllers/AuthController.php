<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Connect request / Подключаем запросы
use App\Http\Requests\RegisterRequest;

// Connect models / Подключаем модели
use App\Models\User;

// Connect Hash / Подключаем Hash
use Illuminate\Support\Facades\Hash;

// Connect Auth / Подключаем Auth
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Get data for login / Получаем данные для авторизации
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Check if user exists / Проверяем, существует ли пользователь
        $user = Auth::attempt($credentials);

        if (!$user) {
            // Response if user not found / Ответ, если пользователь не найден
            return response()->json([
                'message' => 'Invalid credentials / Неверные учетные данные',
            ], 401);
        } else {
            // Response if user found / Ответ, если пользователь найден
            return response()->json([
                'message' => 'User logged in successfully / Пользователь успешно вошел в систему',
                'data' => [
                    'full_name' => Auth::user()->full_name, // Get full name method in User model / Получаем метод полного имени в модели User
                    'email' => Auth::user()->email,
                    'phone' => Auth::user()->phone,
                    'token' => Auth::user()->createToken('auth_token')->plainTextToken, // Create token for user / Создаем токен для пользователя
                ],
            ], 200);
        }

    }

    public function register(RegisterRequest $request)
    {
        // Get data for register / Получаем данные для регистрации
        $credentials = $request->validated();

        try { 
            // Create user
            $user = User::create([
                'first_name' => $credentials['first_name'],
                'last_name' => $credentials['last_name'],
                'patronymic' => $credentials['patronymic'],
                'phone' => $credentials['phone'],
                'email' => $credentials['email'],
                'password' => Hash::make($credentials['password']),
                'profile_photo_path' => $credentials['profile_photo_path'] ?? null, // Учитываем, что поле может быть пустым
            ]);

            // Response after successful register / Ответ после успешной регистрации
            return response()->json([
                'message' => 'User created successfully / Пользователь успешно создан',
                'data' => [
                    'full_name' => $user->full_name, // Get full name method in User model / Получаем метод полного имени в модели User
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'profile_photo_path' => $user->profile_photo_path,
                ],
            ], 201);

        } catch (\Exception $e) {
            // Handle exception / Обработка исключения
            return response()->json([
                'message' => 'Error creating user / Ошибка при создании пользователя',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
