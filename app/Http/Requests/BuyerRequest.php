<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BuyerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'address' => 'required',
            'code' => 'required',
            'limit_debt' => 'nullable',
            'limit_date_debt' => 'nullable'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama buyer harus diisi',
            'address.required' => 'Alamat pembeli haris diisi',
            'code.required' => 'Code pembeli harus diisi'
        ];
    }

    public function prepareForValidation()
    {
        if(!$this->limit_debt) $this->merge(['limit_debt' => null]); 
        if(!$this->limit_date_debt) $this->merge(['limit_date_debt' => null]); 
    }
}
