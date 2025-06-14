<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use App\Notifications\CustomResetPassword;

class AuthController extends Controller
{
    /**
     * Login user / Авторизация пользователя
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Пожалуйста, введите email',
            'email.email' => 'Некорректный формат email',
            'password.required' => 'Пожалуйста, введите пароль',
            'password.string' => 'Пароль должен быть строкой',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Неправильный логин или пароль',
            ], 401);
        }

        $user = Auth::user();

        return response()->json([
            'message' => 'User logged in successfully / Пользователь успешно вошел в систему',
            'data' => [
                'full_name' => $user->full_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'token' => $user->createToken('auth_token')->plainTextToken,
                'date_of_birth' => $user->date_of_birth,
            ],
        ], 200);
    }

    /**
     * Register user / Регистрация пользователя
     */
    public function register(RegisterRequest $request)
    {
        $credentials = $request->validated();

        try {
            $user = User::create([
                'first_name' => $credentials['first_name'],
                'last_name' => $credentials['last_name'],
                'patronymic' => $credentials['patronymic'],
                'phone' => $credentials['phone'],
                'email' => $credentials['email'],
                'password' => Hash::make($credentials['password']),
                'profile_photo_path' => $credentials['profile_photo_path'] ?? null,
            ]);

            return response()->json([
                'message' => 'User created successfully / Пользователь успешно создан',
                'data' => [
                    'full_name' => $user->full_name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'profile_photo_path' => $user->profile_photo_path,
                ],
            ], 201);
        } catch (\Exception $e) {
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
        // Удаляем все токены пользователя (если используем Sanctum для API)
        Auth::user()->tokens()->delete();

        // Возвращаем успешный ответ
        return response()->json([
            'message' => 'User logged out successfully / Пользователь успешно вышел из системы',
        ], 200);
    }

    /**
     * Forgot password / Забыли пароль
     */
    public function forgotPassword(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(['email' => $credentials['email']]);


        if ($status === Password::RESET_LINK_SENT) {
            return response()->json([
                'message' => 'Password reset link sent to your email / Ссылка для сброса пароля отправлена на вашу электронную почту',
            ], 200);
        }

        return response()->json([
            'message' => 'Unable to send reset link / Не удалось отправить ссылку для сброса пароля',
        ], 400);
    }

    /**
     * Reset password / Сброс пароля
     */
    public function resetPassword(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
            'token' => 'required|string',
        ]);

        $status = Password::reset(
            $credentials,
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json([
                'message' => 'Password reset successfully / Пароль успешно сброшен',
            ], 200);
        }

        return response()->json([
            'message' => 'Invalid or expired token / Неверный или истекший токен',
        ], 400);
    }

    public function changePassword(Request $request)
    {
        $credentials = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if (!Hash::check($credentials['current_password'], $user->password)) {
            return response()->json([
                'message' => 'Current password is incorrect / Текущий пароль неверен',
            ], 401);
        }

        $user->password = Hash::make($credentials['new_password']);
        $user->save();

        return response()->json([
            'message' => 'Password changed successfully / Пароль успешно изменен',
        ], 200);
    }
}
