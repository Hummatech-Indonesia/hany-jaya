<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'supplier_id' => 'required|exists:suppliers,id',
            'product_id' => 'required|array',
            'product_id.*' => 'required|exists:products,id',
            'product_unit_id' => 'required|array',
            'product_unit_id.*' => 'required|exists:product_units,id',
            'buy_price_per_unit' => 'required|array',
            'buy_price_per_unit.*' => 'required|integer|min:0',
            'buy_price' => 'required|array',
            'buy_price.*' => 'required|integer|min:0',
            'quantity' => 'required|array',
            'quantity.*' => 'required|integer|min:0',
        ];
    }
}
