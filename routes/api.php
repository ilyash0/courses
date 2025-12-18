<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\OrderController;

Route::post('/registr', [AuthController::class, 'register']);
Route::post('/auth', [AuthController::class, 'authenticate']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/courses', [CourseController::class, 'index']);
    Route::get('/courses/{courseId}', [CourseController::class, 'showLessons']);
    Route::post('/courses/{courseId}/buy', [OrderController::class, 'buyCourse']);

    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{orderId}', [OrderController::class, 'cancel']);

    Route::post('/logout', [AuthController::class, 'logout']);
});
