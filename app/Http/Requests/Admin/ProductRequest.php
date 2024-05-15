<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'outlet_id' => 'required|exists:outlets,id',
            'unit_id' => 'required|exists:units,id',
            'code' => ['required', Rule::unique('products', 'code')->ignore($this->product)],
            'name' => 'required|max:255',
            'quantity' => 'nullable',
            'selling_price' => 'required|integer',
            'image' => 'nullable|mimes:png,jpg,jpeg',
            'supplier_id' => 'required|array',
            'supplier_id.*' => [Rule::exists('suppliers', 'id')]
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
            'category_id.required' => 'Kategori harus dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'outlet_id.required' => 'Outlet harus dipilih.',
            'outlet_id.exists' => 'Outlet yang dipilih tidak valid.',
            'unit_id.required' => 'Satuan harus dipilih.',
            'unit_id.exists' => 'Satuan yang dipilih tidak valid.',
            'code.required' => 'Kode produk harus diisi.',
            'code.unique' => 'Kode produk sudah digunakan.',
            'name.required' => 'Nama produk harus diisi.',
            'name.max' => 'Nama produk tidak boleh melebihi 255 karakter.',
            'selling_price.required' => 'Harga jual harus diisi.',
            'selling_price.integer' => 'Harga jual harus berupa angka.',
            'image.mimes' => 'Format gambar harus berupa PNG, JPG, atau JPEG.',
            'supplier_id.required' => 'Supplier wajib diisi',
            'supplier_id.*.exists' => 'Supplier yang anda pilih tidak tersedia'
        ];
    }
}
