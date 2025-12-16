<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\CourseRequest;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Course::query();

        $allCourses = $query->orderBy('created_at', 'desc')->get();

        $perPage = 5;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $allCourses->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $paginator = new LengthAwarePaginator(
            $currentItems,
            $allCourses->count(),
            $perPage,
            $currentPage,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'pageName' => 'page',
            ]
        );

        return view('courses.index', ['courses' => $paginator]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        if ($request->hasFile('cover_image_path')) {
            $image = $request->file('cover_image_path');
            if ($image->isValid()) {
                $originalExtension = $image->getClientOriginalExtension();
                $fileName = 'mpic_' . uniqid() . '.' . $originalExtension;
                $image->move(public_path('images'), $fileName);

                $validatedData['cover_image_path'] = $fileName;
            } else {
                return back()->withErrors(['cover_image_path' => 'Файл изображения недействителен.'])->withInput();
            }
        }

        Course::create($validatedData);

        return redirect()->route('courses.index')->with('success', 'Курс успешно создан.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course): View
    {
        return view('courses.edit', ['course' => $course]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseRequest $request, Course $course): RedirectResponse
    {
        $validatedData = $request->validated();

        if ($request->hasFile('cover_image_path')) {
            $image = $request->file('cover_image_path');
            if ($image->isValid()) {
                if ($course->cover_image_path && file_exists(public_path('images/' . $course->cover_image_path))) {
                    unlink(public_path('images/' . $course->cover_image_path));
                }

                $originalExtension = $image->getClientOriginalExtension();
                $fileName = 'mpic_' . uniqid() . '.' . $originalExtension;
                $image->move(public_path('images'), $fileName);

                $validatedData['cover_image_path'] = $fileName;
            } else {
                return back()->withErrors(['cover_image_path' => 'Файл изображения недействителен.'])->withInput();
            }
        }

        $course->update($validatedData);

        return redirect()->route('courses.index')->with('success', 'Курс успешно обновлен.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course): RedirectResponse
    {
        if ($course->orders()->exists()) {
            return redirect()->back()->withErrors(['error' => 'Невозможно удалить курс, на который есть записи студентов.']);
        }

        if ($course->cover_image_path && file_exists(public_path('images/' . $course->cover_image_path))) {
            unlink(public_path('images/' . $course->cover_image_path));
        }

        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Курс успешно удален.');
    }
}
