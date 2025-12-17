<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Panel\AuthController;
use App\Http\Controllers\Panel\CourseController;
use App\Http\Controllers\Panel\LessonController;
use App\Http\Controllers\Panel\StudentController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
})->name('home');

Route::prefix('course-admin')->group(function () {

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.send');

    Route::middleware(['auth'])->group(function () {
        Route::get('/', function () {
            return redirect()->route('courses.index');
        })->name('dashboard');

        Route::resource('courses', CourseController::class);

        Route::resource('courses.lessons', LessonController::class)->except(['show', 'index']);

        Route::get('/students', [StudentController::class, 'index'])->name('students.index');

        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});
