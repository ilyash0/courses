<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CheckCertificateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

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
}
