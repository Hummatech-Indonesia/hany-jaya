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
            'product_id' => 'required|exists:products,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'quantity' => 'required|integer|min:0',
            'buy_price' => 'required|integer|min:0'
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
            'product_id.required' => 'Kolom ID Produk wajib diisi.',
            'product_id.exists' => 'ID Produk yang dipilih tidak valid.',
            'supplier_id.required' => 'Kolom ID Pemasok wajib diisi.',
            'supplier_id.exists' => 'ID Pemasok yang dipilih tidak valid.',
            'quantity.required' => 'Kolom jumlah wajib diisi.',
            'quantity.integer' => 'Kolom jumlah harus berupa angka.',
            'quantity.min' => 'Kolom jumlah harus lebih besar atau sama dengan 0.',
            'buy_price.required' => 'Kolom harga beli wajib diisi.',
            'buy_price.integer' => 'Kolom harga beli harus berupa angka.',
            'buy_price.min' => 'Kolom harga beli harus lebih besar atau sama dengan 0.'
        ];
    }
}
