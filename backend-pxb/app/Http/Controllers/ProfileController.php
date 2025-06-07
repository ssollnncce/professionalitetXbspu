<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\CourseApplication;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function getUserProfile()
    {
        // Get the authenticated user / Получаем авторизованного пользователя
        $user = Auth::user();

        // Format the response / Форматируем ответ
        return response()->json([
            'message' => 'User profile retrieved successfully / Профиль пользователя успешно получен',
            'id' => $user->id,
            'data' => [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'patronymic' => $user->patronymic,
                'email' => $user->email,
                'phone' => $user->phone,
                'profile_photo_path' => $user->profile_photo_path,
                'date_of_birth' => $user->date_of_birth ? Carbon::parse($user->date_of_birth)->format('Y-m-d') : null,
            ],
        ])->setStatusCode(200);
    }
    public function updateUserProfile(Request $request)
    {
        // Validate the request / Валидируем запрос
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'patronymic' => 'nullable|string|max:255',
            'profile_photo_path' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
        ], [
            'first_name.required' => 'Пожалуйста, введите имя',
            'first_name.string' => 'Имя должно быть строкой',
            'first_name.max' => 'Имя не должно превышать 255 символов',

            'last_name.required' => 'Пожалуйста, введите фамилию',
            'last_name.string' => 'Фамилия должна быть строкой',
            'last_name.max' => 'Фамилия не должна превышать 255 символов',

            'patronymic.string' => 'Отчество должно быть строкой',
            'patronymic.max' => 'Отчество не должно превышать 255 символов',
        ]);

        // Get the authenticated user / Получаем авторизованного пользователя
        $user = Auth::user();

        // Update the user profile / Обновляем профиль пользователя
        $user->update($data);

        // Format the response / Форматируем ответ
        return response()->json([
            'message' => 'User profile updated successfully / Профиль пользователя успешно обновлен',
            'data' => [
                'full_name' => $user->full_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'profile_photo_path' => $user->profile_photo_path,
                'date_of_birth' => $user->date_of_birth,
            ],
        ])->setStatusCode(200);
    }

    public function getUserCourses(): \Illuminate\Http\JsonResponse
    {
        // Get the authenticated user / Получаем авторизованного пользователя
        $user = Auth::user();

        // Get the user's courses / Получаем курсы пользователя
        $courses_inprocess = CourseApplication::where('user_id', $user->id)
            ->where('status', 'Confirmed')
            ->with([
                'course' => function ($query) {
                    $query->select('id', 'name', 'description', 'image_path', 'teacher_id', 'duration', 'course_family_id');
                },
                'course.teacher' => function ($query) {
                    $query->select('id', 'first_name', 'last_name', 'patronymic');
                },
                'course.courseFamily' => function ($query) {
                    $query->select('id', 'name', 'theme_color');
                },
            ])
            ->get();

        $formatted_inprocess_courses = $courses_inprocess->map(function ($course) {
            return [
                'id' => $course->id,
                'course_id' => $course->course_id,
                'user_id' => $course->user_id,
                'status' => $course->status,
                'color' => $course->course->courseFamily->theme_color,
                'description' => [
                    'name' => $course->course->name,
                    'description' => $course->course->description,
                    'image_path' => $course->course->image_path,
                    'teacher' => $course->course->teacher->first_name . ' ' . $course->course->teacher->last_name,
                    'duration' => $course->course->duration,
                    'course_family' => $course->course->courseFamily->name,
                ],
            ];
        });

        // Format the response / Форматируем ответ
        return response()->json([
            'message' => 'User courses retrieved successfully / Курсы пользователя успешно получены',
            'inprocess_courses' => $formatted_inprocess_courses,
        ])->setStatusCode(200);
    }
}
