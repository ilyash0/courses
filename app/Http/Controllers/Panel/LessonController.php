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
            return redirect()->back()->with('error', 'Для курса уже добавлено максимальное количество уроков (5).');
        }
        return view('lessons.create', ['course' => $course]);
    }

    /**
     * Store a newly created resource in storage for a specific course.
     */
    public function store(LessonRequest $request, Course $course): RedirectResponse
    {
        if ($course->lessons()->count() >= 5) {
            return redirect()->back()->with('error', 'Для курса уже добавлено максимальное количество уроков (5).');
        }

        $validatedData = $request->validated();
        $validatedData['course_id'] = $course->id;

        $totalHoursAfterAdd = $course->lessons()->sum('duration_hours') + $validatedData['duration_hours'];
        if ($totalHoursAfterAdd > $course->duration_hours) {
            return redirect()->back()->withInput()
                ->withErrors(['duration_hours' => "Суммарная длительность уроков ($totalHoursAfterAdd ч.) превысит общую длительность курса ($course->duration_hours ч.)."]);
        }

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

        $totalHoursBeforeChange = $course->lessons()->sum('duration_hours');
        $totalHoursAfterUpdate = $totalHoursBeforeChange - $lesson->duration_hours + $validatedData['duration_hours'];

        if ($totalHoursAfterUpdate > $course->duration_hours) {
            return redirect()->back()->withInput()
                ->withErrors(['duration_hours' => "Обновление урока приведет к превышению суммарной длительности уроков ($totalHoursAfterUpdate ч.) над общей длительностью курса ($course->duration_hours ч.)."]);
        }

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
            return redirect()->back()->with('error', 'Невозможно удалить урок, пока есть активные записи на курс.');
        }

        $lesson->delete();

        return redirect()->route('courses.show', ['course' => $course])->with('success', 'Урок успешно удален.');
    }
}
