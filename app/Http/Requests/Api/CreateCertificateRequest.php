<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateCertificateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'student_id' => 'required|integer|exists:users,id', // Проверяем, что ID студента - целое число и существует в таблице users
            'course_id' => 'required|integer|exists:courses,id', // Проверяем, что ID курса - целое число и существует в таблице courses
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
            'student_id.required' => 'ID студента обязателен.',
            'student_id.integer' => 'ID студента должен быть числом.',
            'student_id.exists' => 'Указанный студент не существует.',
            'course_id.required' => 'ID курса обязателен.',
            'course_id.integer' => 'ID курса должен быть числом.',
            'course_id.exists' => 'Указанный курс не существует.',
        ];
    }
}
