<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class CourseController extends Controller
{
    /**
     * Display a listing of the courses.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $allCourses = Course::orderBy('created_at', 'desc')->paginate(5);

        $data = [
            'data' => $allCourses->getCollection()->map(function ($course) {
                return [
                    'id' => $course->id,
                    'name' => $course->name,
                    'description' => $course->description,
                    'hours' => $course->duration_hours,
                    'img' => $course->cover_image_url,
                    'start_date' => $course->start_date->format('Y-m-d'),
                    'end_date' => $course->end_date->format('Y-m-d'),
                    'price' => $course->price,
                ];
            })->toArray(),
            'pagination' => [
                'total' => $allCourses->lastPage(),
                'current' => $allCourses->currentPage(),
                'per_page' => $allCourses->perPage(),
                'total_items' => $allCourses->total(),
            ]
        ];

        return response()->json($data, 200);
    }

    /**
     * Display the lessons for a specific course.
     *
     * @param int $courseId
     * @return JsonResponse
     */
    public function showLessons(int $courseId): JsonResponse
    {
        $course = Course::find($courseId);

        if (!$course) {
            return response()->json([
                'message' => 'Курс не найден.'
            ], 404);
        }

        $lessons = $course->lessons;
        $data = [
            'data' => $lessons->map(function ($lesson) {
                return [
                    'id' => $lesson->id,
                    'name' => $lesson->title,
                    'description' => $lesson->content,
                    'video_link' => $lesson->video_link,
                    'hours' => $lesson->duration_hours,
                ];
            })->toArray()
        ];

        return response()->json($data);
    }
}
