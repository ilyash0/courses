<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class StudentController extends Controller
{
    /**
     * Display a listing of students enrolled in courses.
     */
    public function index(Request $request): View
    {
        $query = Order::with(['user', 'course']); // Загружаем связанные user и course

        $courseFilter = $request->input('course_filter');
        if ($courseFilter) {
            $query->where('course_id', $courseFilter);
        }

        $allOrders = $query->orderBy('enrollment_date', 'desc')->get();

        $perPage = 5;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $allOrders->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $paginator = new LengthAwarePaginator(
            $currentItems,
            $allOrders->count(),
            $perPage,
            $currentPage,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'pageName' => 'page',
            ]
        );

        $courses = Course::all();

        return view('admin.students.index', [
            'orders' => $paginator,
            'courses' => $courses,
            'selectedCourse' => $courseFilter,
        ]);
    }
}
