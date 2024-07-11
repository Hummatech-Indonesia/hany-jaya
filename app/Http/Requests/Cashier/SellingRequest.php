<?php

namespace App\Http\Requests\Cashier;

use App\Rules\SellingRule;
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
            'telp' => 'nullable|max:15',
            'product_unit_price'=>'required',
            'pay' => 'nullable',
            'code_debt' => 'nullable',
            'return' => 'nullable',
            'status_payment' => ['required', new SellingRule],
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
    /**
     * Method messages
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'product_unit_price.required'=>'Harga Satuan wajib diisi',
            'address.required' => 'Alamat wajib diisi.',
            'status_payment.required' => 'Status pembayaran wajib diisi.',
            'product_id.required' => 'Produk wajib dipilih.',
            'product_id.array' => 'Produk harus berupa array.',
            'product_id.*.required' => 'Produk wajib dipilih.',
            'product_id.*.exists' => 'Produk yang dipilih tidak valid.',
            'product_unit_id.required' => 'Unit produk wajib dipilih.',
            'product_unit_id.array' => 'Unit produk harus berupa array.',
            'product_unit_id.*.required' => 'Unit produk wajib dipilih.',
            'product_unit_id.*.exists' => 'Unit produk yang dipilih tidak valid.',
            'quantity.required' => 'Kuantitas wajib diisi.',
            'quantity.array' => 'Kuantitas harus berupa array.',
            'quantity.*.required' => 'Kuantitas wajib diisi.',
            'selling_price.required' => 'Harga jual wajib diisi.',
            'selling_price.array' => 'Harga jual harus berupa array.',
            'selling_price.*.required' => 'Harga jual wajib diisi.',
            'telp.max' => 'Max nomor telp adalah 15.',
        ];
    }
}
