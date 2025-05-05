<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    public function getAllCourses(Request $request)
    {
        //Get data for sorting / Получаем данные для сортировки

        $courseFamily = $request->validate([
            'course_family' => 'nullable|integer|exists:course_families,id',
        ]);

        /**
         * Get courses by course family / Получаем курсы по семейству курсов
         * If course family is not set, get all courses / Если семейство курсов не указано, получаем все курсы
         */

        $courses = Course::when(
            isset($courseFamily['course_family']) && $courseFamily['course_family'] != 0,
            function ($query) use ($courseFamily) {
                $query->where('course_family_id', $courseFamily['course_family']);
            }
        )->with('courseFamily', 'teacher')->get();

        // Format the response / Форматируем ответ

        $formattedCourses = $courses->map(function ($course) {
            return [
                'id' => $course->id,
                'name' => $course->name,
                'description' => $course->description,
                'image_path' => $course->image_path,
                'course_family' => [
                    'id' => $course->courseFamily->id,
                    'name' => $course->courseFamily->name,
                ],
                'teacher' => [
                    'id' => $course->teacher->id,
                    'full_name' => $course->teacher->full_name,
                ],
                'price' => $course->price,
                'duration' => $course->duration,
                'start_date' => $course->start_date->format('d-m-Y'),
            ];
        });

        // Return the response / Возвращаем ответ

        return response()->json([
            'message' => 'Courses retrieved successfully / Курсы успешно получены',
            'data' => $formattedCourses,
        ])->setStatusCode(200, );
    }

    public function getCourseDetail($id)
    {
        //Get course by id / Получаем курс по id

        $course = Course::with('courseFamily', 'teacher')->findOrFail($id);

        // Format the response / Форматируем ответ

        $formattedCourse = [
            'id' => $course->id,
            'name' => $course->name,
            'description' => $course->description,
            'image_path' => $course->image_path,
            'course_family' => [
                'id' => $course->courseFamily->id,
                'name' => $course->courseFamily->name,
            ],
            'teacher' => [
                'id' => $course->teacher->id,
                'full_name' => $course->teacher->full_name,
            ],
            'price' => $course->price,
            'duration' => $course->duration,
            'start_date' => $course->start_date->format('d-m-Y'),
        ];

        // Return the response / Возвращаем ответ

        return response()->json([
            'message' => 'Course retrieved successfully / Курс успешно получен',
            'data' => $formattedCourse,
        ])->setStatusCode(200, );
    }
}
