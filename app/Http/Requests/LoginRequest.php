<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
            'remember_me' => 'nullable'
        ];
    }

    /**
     * Custom Validation Messages
     *
     * @return array<string, mixed>
     */

    public function messages(): array
    {
        return [
            'email.exists' => 'Email yang anda inputkan belum terdaftar',
            'email.required' => 'Email Wajib Diisi!',
            'email.email' => 'Email Tidak Valid!',
            'password.required' => 'Password Wajib Diisi!'
        ];
    }
}
