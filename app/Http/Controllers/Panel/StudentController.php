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
    public function index(): View
    {
        $query = Order::with(['user', 'course']);

        $courseFilter = request('course_filter');
        if ($courseFilter) {
            $query->where('course_id', $courseFilter);
        }

        return view('students.index', [
            'orders' => $query->orderBy('created_at', 'desc')->paginate(5),
            'courses' => Course::orderBy('name')->get(),
        ]);
    }
}
