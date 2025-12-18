<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => [
                'required',
                'string',
                'min:3',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[_#!%]).*$/'
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
            'email.required' => 'Поле email обязательно для заполнения.',
            'email.email' => 'Поле email должно быть действительным адресом электронной почты.',
            'email.unique' => 'Пользователь с таким email уже существует.',
            'password.required' => 'Поле пароля обязательно для заполнения.',
            'password.min' => 'Поле пароля должно содержать не менее :min символов.',
            'password.regex' => 'Пароль должен содержать хотя бы одну букву верхнего регистра, одну букву нижнего регистра, одну цифру и один из следующих спецсимволов: _, #, !, %.',
        ];
    }
}
