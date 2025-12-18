<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => [
                'required', 'string', 'min:3',
                'regex:/^(?=.*[a-zа-яё])(?=.*[A-ZА-ЯЁ])(?=.*\d)(?=.*[_#!%]).*$/u'
            ],
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
            'name.required' => 'Поле имени обязательно для заполнения.',
            'name.string' => 'Поле имени должно быть строкой.',
            'name.max' => 'Поле имени не может превышать :max символов.',
            'email.required' => 'Поле email обязательно для заполнения.',
            'email.email' => 'Поле email должно быть действительным адресом электронной почты.',
            'email.unique' => 'Пользователь с таким email уже существует.',
            'password.required' => 'Поле пароля обязательно для заполнения.',
            'password.min' => 'Поле пароля должно содержать не менее :min символов.',
            'password.regex' => 'Пароль должен содержать хотя бы одну букву верхнего регистра, одну букву нижнего регистра, одну цифру и один из следующих спецсимволов: _, #, !, %.',
        ];
    }
}
