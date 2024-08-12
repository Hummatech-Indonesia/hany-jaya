<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->user)],
            'password' => 'nullable',
            "role" => 'required',
            'role.*' => 'required|exists:roles,name',
        ];
    }

    /**
     * messages
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Kolom nama harus diisi.',
            'email.required' => 'Kolom email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.nullable' => 'Kolom password tidak boleh diisi.',
            'role.required' => 'Kolom role harus diisi.',
            'role.*.required' => 'Kolom role harus diisi.',
            'role.*.exists' => 'Role tidak valid.',
        ];
    }
}
