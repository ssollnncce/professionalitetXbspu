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
    /**
     * Login user / Авторизация пользователя
     */

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

    /**
     * Register user / Регистрация пользователя
     */

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

    /**
     * Logout user / Выход пользователя
     */

    public function logout(Request $request)
    {
        // Logout user / Выход пользователя
        Auth::user()->tokens()->delete();

        return response()->json([
            'message' => 'User logged out successfully / Пользователь успешно вышел из системы',
        ], 200);
    }

    /**
     * Forgot password / Забыли пароль
     */
    public function forgotPassword(Request $request){
        // Get data for forgot password / Получаем данные для сброса пароля
        $credentials = $request->validate([
            'email' => 'required|email',
        ]);
        // Get email from database / Получаем email из базы данных
        $user = User::where('email', $credentials['email'])->first();

        // Check if user exists / Проверяем, существует ли пользователь
        if (!$user) {
            // Response if user not found / Ответ, если пользователь не найден
            return response()->json([
                'message' => 'User not found / Пользователь не найден',
            ], 404);
        } else {
            // Send reset password link / Отправляем ссылку для сброса пароля
            $user->sendPasswordResetNotification($user->createToken('auth_token')->plainTextToken);
            return response()->json([
                'message' => 'Password reset link sent to your email / Ссылка для сброса пароля отправлена на вашу электронную почту',
            ], 200);
        }
    }

    /**
     * Reset password / Сброс пароля
     */
    public function resetPassword(Request $request){
        // Get data for reset password / Получаем данные для сброса пароля
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
            'token' => 'required|string',
        ]);

        // Get user by email / Получаем пользователя по email
        $user = User::where('email', $credentials['email'])->first();

        // Check if user exists / Проверяем, существует ли пользователь
        if (!$user) {
            // Response if user not found / Ответ, если пользователь не найден
            return response()->json([
                'message' => 'User not found / Пользователь не найден',
            ], 404);
        } else {
            // Reset password / Сброс пароля
            $user->password = Hash::make($credentials['password']);
            $user->save();

            return response()->json([
                'message' => 'Password reset successfully / Пароль успешно сброшен',
            ], 200);
        }
    }

}
