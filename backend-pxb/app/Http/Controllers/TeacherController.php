<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;

class TeacherController extends Controller
{
    public function getAllTeachers()
    {
        // Get all teachers / Получаем всех преподавателей
        $teachers = Teacher::all();

        // Format the response / Форматируем ответ
        $formattedTeachers = $teachers->map(function ($teacher) {
            return [
                'id' => $teacher->id,
                'full_name' => $teacher->full_name,
            ];
        });

        // Return the response / Возвращаем ответ
        return response()->json([
            'message' => 'Teachers retrieved successfully / Преподаватели успешно получены',
            'data' => $formattedTeachers,
        ])->setStatusCode(200);
    }
}
