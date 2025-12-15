<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;

class LessonRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:50'],
            'content' => ['required', 'string'],
            'video_link' => ['nullable', 'url', 'regex:/^https:\/\/super-tube\.cc\/video\/v\d+$/'],
            'duration_hours' => ['required', 'integer', 'min:1', 'max:4'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Заголовок урока обязателен.',
            'title.max' => 'Заголовок урока не может превышать :max символов.',
            'content.required' => 'Содержание урока обязательно.',
            'video_link.url' => 'Видео-ссылка должна быть действительным URL.',
            'video_link.regex' => 'Видео-ссылка должна соответствовать формату SuperTube (https://super-tube.cc/video/vXXXXX).',
            'duration_hours.required' => 'Длительность урока обязательна.',
            'duration_hours.integer' => 'Длительность урока должна быть целым числом.',
            'duration_hours.min' => 'Длительность урока должна быть не меньше :min часа.',
            'duration_hours.max' => 'Длительность урока не может быть больше :max часов.',
        ];
    }
}
