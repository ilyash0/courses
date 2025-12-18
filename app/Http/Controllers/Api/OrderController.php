<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the user's orders (courses they are enrolled in).
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $orders = $request->user()->orders()->with('course')->get();

        $data = [
            'data' => $orders->map(function ($order) {
                return [
                    'id' => $order->id,
                    'payment_status' => $order->payment_status,
                    'course' => [
                        'id' => $order->course->id,
                        'name' => $order->course->name,
                        'description' => $order->course->description,
                        'hours' => $order->course->duration_hours,
                        'img' => $order->course->cover_image_url,
                        'start_date' => $order->course->start_date->format('Y-m-d'),
                        'end_date' => $order->course->end_date->format('Y-m-d'),
                        'price' => $order->course->price,
                    ]
                ];
            })->toArray()
        ];

        return response()->json($data);
    }

    /**
     * Process a request to buy a course.
     *
     * @param Request $request
     * @param int $courseId
     * @return JsonResponse
     */
    public function buyCourse(Request $request, int $courseId): JsonResponse
    {
        $user = $request->user();
        $course = Course::find($courseId);

        if (!$course) {
            return response()->json([
                'message' => 'Курс не найден'
            ], 404);
        }

        if ($course->start_date->isPast()) {
            return response()->json([
                'message' => 'Невозможно записаться на курс, который уже начался или закончился'
            ], 422);
        }

        if ($user->orders()->where('course_id', $course->id)->first()) {
            return response()->json([
                'message' => 'Вы уже записаны на этот курс'
            ], 422);
        }

        Order::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'payment_status' => 'pending',
        ]);

        return response()->json([
            'pay_url' => 'Ссылка на оплату курса',
        ]);
    }

    /**
     * Cancel an order (unenroll from a course).
     *
     * @param Request $request
     * @param int $orderId
     * @return JsonResponse
     */
    public function cancel(Request $request, int $orderId): JsonResponse
    {
        $user = $request->user();
        $order = Order::find($orderId);

        if (!$order || $order->user_id !== $user->id) {
            return response()->json([
                'message' => 'Заказ не найден или не принадлежит пользователю'
            ], 404);
        }

        if ($order->payment_status === 'success') {
            return response()->json([
                'status' => 'Уже оплачен'
            ], 418);
        }

        $order->delete();

        return response()->json([
            'status' => 'Успешно'
        ]);
    }
}
