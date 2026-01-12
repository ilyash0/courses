<?php

use App\Http\Controllers\Panel\CertificateController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Panel\AuthController;
use App\Http\Controllers\Panel\CourseController;
use App\Http\Controllers\Panel\LessonController;
use App\Http\Controllers\Panel\StudentController;

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

        Route::get('/certificates', [CertificateController::class, 'index'])->name('certificates.index');
    });
});
