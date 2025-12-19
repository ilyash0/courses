<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CheckCertificateRequest;
use App\Http\Requests\Api\CreateCertificateRequest;
use App\Models\Certificate;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Str;

class CertificateController extends Controller
{
    /**
     * Check the validity of a certificate number.
     *
     * @param CheckCertificateRequest $request
     * @return JsonResponse
     */
    public function check(CheckCertificateRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $certificateNumber = $validatedData['sertikate_number'];

        $lastDigit = substr($certificateNumber, -1);

        if ($lastDigit === '1') {
            return response()->json([
                'status' => 'success'
            ]);
        } elseif ($lastDigit === '2') {
            return response()->json([
                'status' => 'failed'
            ]);
        } else {
            Log::warning("Неверный формат номера сертификата: {$certificateNumber}. Последняя цифра - это не 1 и не 2");
            return response()->json([
                'status' => 'failed'
            ]);
        }
    }

    /**
     * Generate a certificate number.
     *
     * @param CreateCertificateRequest $request
     * @return JsonResponse
     */
    public function create(CreateCertificateRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $studentId = $validatedData['student_id'];
        $courseId = $validatedData['course_id'];

        $order = Order::where('user_id', $studentId)
            ->where('course_id', $courseId)
            ->where('payment_status', 'success')
            ->first();

        if (!$order) {
            return response()->json([
                'message' => 'Данный студент не записан на указанный курс или курс не оплачен'
            ], 422);
        }

        if (Certificate::where('user_id', $studentId)->where('course_id', $courseId)->exists()) {
            return response()->json([
                'message' => 'Сертификат уже существует для этого студента на текущем курса'
            ], 422);
        }

        $externalPart = Str::upper(Str::random(6));

        $localPart = Str::random(5) . '1';

        $certificateNumber = $externalPart . $localPart;

        Certificate::create([
            'user_id' => $studentId,
            'course_id' => $courseId,
            'certificate_number' => $certificateNumber,
        ]);

        return response()->json([
            'certificate_number' => $certificateNumber,
        ]);
    }
}
