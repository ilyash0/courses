<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class CheckCertificateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'certificate_number' => ['required', 'string', 'regex:/^[A-Za-z0-9]{11}[12]$/'], // 11 любых символов + 1 или 2 в конце
        ];
    }

    /**
     * Get custom messages for validation errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'certificate_number.required' => 'Номер сертификата обязателен.',
            'certificate_number.string' => 'Номер сертификата должен быть строкой.',
            'certificate_number.regex' => 'Номер сертификата должен состоять из 12 символов, где последние два - это цифра (1 или 2).',
        ];
    }
}
