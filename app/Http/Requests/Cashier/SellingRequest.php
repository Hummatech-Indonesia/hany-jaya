<?php

namespace App\Http\Requests\Cashier;

use Illuminate\Foundation\Http\FormRequest;

class SellingRequest extends FormRequest
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
            'address' => 'required',
            'pay' => 'required',
            'return' => 'required',
            'product_id' => 'required|array',
            'product_id.*' => 'required|exists:products,id',
            'product_unit_id' => 'required|array',
            'product_unit_id.*' => 'required|exists:product_units,id',
            'quantity' => 'required|array',
            'quantity.*' => 'required',
            'selling_price' => 'required|array',
            'selling_price.*' => 'required',
        ];
    }
}
