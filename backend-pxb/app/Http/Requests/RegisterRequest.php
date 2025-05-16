<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'patronymic' => 'required|string|max:255',
            'phone' => 'required|string|max:16|unique:users,phone',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'profile_photo_path' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Пожалуйста, введите имя',
            'first_name.string' => 'Имя должно быть строкой',
            'first_name.max' => 'Имя не должно превышать 255 символов',

            'last_name.required' => 'Пожалуйста, введите фамилию',
            'last_name.string' => 'Фамилия должна быть строкой',
            'last_name.max' => 'Фамилия не должна превышать 255 символов',

            'patronymic.required' => 'Пожалуйста, введите отчество',
            'patronymic.string' => 'Отчество должно быть строкой',
            'patronymic.max' => 'Отчество не должно превышать 255 символов',

            'phone.required' => 'Пожалуйста, введите телефон',
            'phone.string' => 'Телефон должен быть строкой',
            'phone.max' => 'Телефон не должен превышать 16 символов',
            'phone.unique' => 'Такой телефон уже зарегистрирован',

            'email.required' => 'Пожалуйста, введите email',
            'email.string' => 'Email должен быть строкой',
            'email.email' => 'Некорректный формат email',
            'email.max' => 'Email не должен превышать 255 символов',
            'email.unique' => 'Такой email уже зарегистрирован',

            'password.required' => 'Пожалуйста, введите пароль',
            'password.string' => 'Пароль должен быть строкой',
            'password.min' => 'Пароль должен быть не менее 8 символов',
            'password.confirmed' => 'Пароли не совпадают',

            'profile_photo_path.string' => 'Путь к фото должен быть строкой',
            'profile_photo_path.max' => 'Путь к фото не должен превышать 255 символов',
        ];
    }
}
