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
            'invoice_number' => 'required|unique:purchases,invoice_number',
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
            'pay_date' => 'required',
            'status' => 'nullable'
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
            'supplier_id.required' => 'Kolom ID Pemasok wajib diisi.',
            'supplier_id.exists' => 'ID Pemasok yang dipilih tidak valid.',
            'product_id.required' => 'Kolom ID Produk wajib diisi.',
            'product_id.array' => 'Kolom ID Produk harus berupa array.',
            'product_id.*.required' => 'Setiap ID Produk dalam array wajib diisi.',
            'product_id.*.exists' => 'Salah satu ID Produk yang dipilih tidak valid.',
            'product_unit_id.required' => 'Kolom ID Unit Produk wajib diisi.',
            'product_unit_id.array' => 'Kolom ID Unit Produk harus berupa array.',
            'product_unit_id.*.required' => 'Setiap ID Unit Produk dalam array wajib diisi.',
            'product_unit_id.*.exists' => 'Salah satu ID Unit Produk yang dipilih tidak valid.',
            'buy_price_per_unit.required' => 'Kolom Harga Beli per Unit wajib diisi.',
            'buy_price_per_unit.array' => 'Kolom Harga Beli per Unit harus berupa array.',
            'buy_price_per_unit.*.required' => 'Setiap Harga Beli per Unit dalam array wajib diisi.',
            'buy_price_per_unit.*.integer' => 'Setiap Harga Beli per Unit harus berupa bilangan bulat.',
            'buy_price_per_unit.*.min' => 'Setiap Harga Beli per Unit harus bernilai minimal 0.',
            'buy_price.required' => 'Kolom Total Harga Beli wajib diisi.',
            'buy_price.array' => 'Kolom Total Harga Beli harus berupa array.',
            'buy_price.*.required' => 'Setiap Total Harga Beli dalam array wajib diisi.',
            'buy_price.*.integer' => 'Setiap Total Harga Beli harus berupa bilangan bulat.',
            'buy_price.*.min' => 'Setiap Total Harga Beli harus bernilai minimal 0.',
            'quantity.required' => 'Kolom Kuantitas wajib diisi.',
            'quantity.array' => 'Kolom Kuantitas harus berupa array.',
            'quantity.*.required' => 'Setiap Kuantitas dalam array wajib diisi.',
            'quantity.*.integer' => 'Setiap Kuantitas harus berupa bilangan bulat.',
            'quantity.*.min' => 'Setiap Kuantitas harus bernilai minimal 0.',
            'pay_date.required' => 'Tanggal Pembayaran harus diisi'
        ];
    }

    public function prepareForValidation()
    {
        if($this->tempo && !$this->pay_date) $this->merge(['pay_date' => $this->tempo]);
        if(!$this->tempo && !$this->pay_date && $this->request->get("method") == 'paid') $this->merge(['pay_date' => date('Y-m-d')]);
        if($this->method == "paid") $this->merge(['status' => 'paid']);
        else $this->merge(['status' => 'unpaid']);
    }
}
