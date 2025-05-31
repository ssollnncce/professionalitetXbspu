<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseApplication;

use Illuminate\Support\Facades\Auth;

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
                'age' => $course->age,
                'capacity' => $course->capacity,
                'freeSlots' => $course->remaining_slots,
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
            'age' => $course->age,
        ];

        // Return the response / Возвращаем ответ

        return response()->json([
            'message' => 'Course retrieved successfully / Курс успешно получен',
            'data' => $formattedCourse,
        ])->setStatusCode(200, );
    }

    public function bookCourse(Request $request, $id)
    {
        //Get course by id / Получаем курс по id

        $course = Course::findOrFail($id);

        $user = Auth::user();

        // Book the course / Бронируем курс

        if (!$course->hasAvailibleSlots()) {
            return response()->json(['error' => 'Нет свободных мест на курсе'], 400);
        }

        $book = CourseApplication::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);

        // Return the response / Возвращаем ответ

        return response()->json([
            'message' => 'Course booked successfully / Курс успешно забронирован',
            'data' => [
                'id' => $book->id,

                'course_id' => $course->id,
                'user_id' => $user->id,
                'status' => $book->status,

                'description' => [
                    'course_name' => $course->name,
                    'user_name' => $user->full_name,
                ],
            ],
        ])->setStatusCode(200, );
    }

    public function getCourseFamilies()
    {
        $families = \App\Models\CourseFamily::all(['id', 'name']);
        return response()->json([
            'message' => 'Course families retrieved successfully',
            'data' => $families,
        ], 200);
    }
}
