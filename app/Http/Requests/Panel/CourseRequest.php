<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:30'],
            'description' => ['nullable', 'string', 'max:100'],
            'duration_hours' => ['required', 'integer', 'min:1', 'max:10'],
            'price' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/', 'min:100'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'cover_image_path' => [($this->course ? 'nullable' : 'required'), 'file', 'mimes:jpeg,jpg', 'max:2000']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Название курса обязательно.',
            'name.max' => 'Название курса не может превышать :max символов.',
            'description.max' => 'Описание курса не может превышать :max символов.',
            'duration_hours.required' => 'Продолжительность обязательна.',
            'duration_hours.integer' => 'Продолжительность должна быть целым числом.',
            'duration_hours.min' => 'Продолжительность должна быть не меньше :min часа.',
            'duration_hours.max' => 'Продолжительность не может быть больше :max часов.',
            'price.required' => 'Цена обязательна.',
            'price.numeric' => 'Цена должна быть числом.',
            'price.regex' => 'Цена должна быть в формате xx.xx (например, 150.00).',
            'price.min' => 'Цена не может быть меньше :min.',
            'start_date.required' => 'Дата начала обязательна.',
            'start_date.date' => 'В поле "дата начала" введена не дата.',
            'start_date.date_format' => 'Дата начала должна быть в формате ДД-ММ-ГГГГ (например, 25-12-2025).',
            'end_date.required' => 'Дата окончания обязательна.',
            'end_date.date' => 'В поле "дата окончания" введена не дата.',
            'end_date.date_format' => 'Дата окончания должна быть в формате ДД-ММ-ГГГГ (например, 25-12-2025).',
            'end_date.after_or_equal' => 'Дата окончания должна быть не раньше даты начала.',
            'cover_image_path.required' => 'Обложка курса обязательна при создании.',
            'cover_image_path.file' => 'Поле обложки должно быть файлом.',
            'cover_image_path.mimes' => 'Обложка курса должна быть файлом формата JPEG.',
            'cover_image_path.max' => 'Размер файла обложки не может превышать 2000 Кб.',
        ];
    }
}
