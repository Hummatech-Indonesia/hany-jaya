<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PayDebtRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'pay_debt' => 'required|numeric|min:1',
            'desc' => 'nullable'
        ];
    }

    public function messages()
    {
        return [
            'pay_debt.required' => 'Nominal Hutang wajib dibayar',
            'pay_debt.min' => 'Nominal tidak boleh kurang dari sama dengan 0'
        ];
    }

    public function prepareForValidation()
    {
        if($this->pay_debt) $this->merge(['pay_debt' => (int)$this->pay_debt]);
    }
}
