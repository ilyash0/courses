<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\LessonRequest;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LessonController extends Controller
{
    /**
     * Show the form for creating a new resource for a specific course.
     */
    public function create(Course $course): View|RedirectResponse
    {
        if ($course->lessons()->count() >= 5) {
            return redirect()->back()->withErrors(['error' => 'Для курса уже добавлено максимальное количество уроков (5).']);
        }
        return view('lessons.create', ['course' => $course]);
    }

    /**
     * Store a newly created resource in storage for a specific course.
     */
    public function store(LessonRequest $request, Course $course): RedirectResponse
    {
        if ($course->lessons()->count() >= 5) {
            return redirect()->back()->withErrors(['error' => 'Для курса уже добавлено максимальное количество уроков (5).']);
        }

        $validatedData = $request->validated();
        $validatedData['course_id'] = $course->id;

        Lesson::create($validatedData);

        return redirect()->route('courses.show', ['course' => $course])->with('success', 'Урок успешно создан.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course, Lesson $lesson): View
    {
        if ($lesson->course_id !== $course->id) {
            abort(404);
        }
        return view('lessons.edit', ['course' => $course, 'lesson' => $lesson]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LessonRequest $request, Course $course, Lesson $lesson): RedirectResponse
    {
        if ($lesson->course_id !== $course->id) {
            abort(404);
        }

        $validatedData = $request->validated();

        $lesson->update($validatedData);

        return redirect()->route('courses.show', ['course' => $course])->with('success', 'Урок успешно обновлен.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course, Lesson $lesson): RedirectResponse
    {
        if ($lesson->course_id !== $course->id) {
            abort(404);
        }

        if ($course->orders()->where('payment_status', 'success')->exists()) {
            return redirect()->back()->withErrors(['error' => 'Невозможно удалить урок, пока есть активные записи на курс.']);
        }

        $lesson->delete();

        return redirect()->route('courses.show', ['course' => $course])->with('success', 'Урок успешно удален.');
    }
}
