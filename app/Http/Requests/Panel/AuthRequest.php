<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Поле электронной почты обязательно для заполнения.',
            'email.email' => 'Поле электронной почты должно быть действительным адресом электронной почты.',
            'password.required' => 'Поле пароля обязательно для заполнения.',
        ];
    }
}
