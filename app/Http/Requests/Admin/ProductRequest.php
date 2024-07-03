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
            'unit_id' => 'required|array',
            'unit_id.*' => 'required|exists:units,id',
            'quantity_in_small_unit' => 'required|array',
            'quantity_in_small_unit.*' => 'required',
            'small_unit_id' => 'required|exists:units,id',
            'code' => ['required', Rule::unique('products', 'code')->ignore($this->product)],
            'name' => 'required|max:255',
            'quantity' => 'nullable',
            'selling_price' => 'required|array',
            'selling_price.*' => 'required',
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
            'category_id.required' => 'Katergori wajib dipilih',
            'category_id.exists' => 'Kategori tidak ditemukan',
            'unit_id.required' => 'Satuan wajib dipilih',
            'unit_id.*.required' => 'Satuan wajib dipilih',
            'unit_id.*.exists' => 'Satuan tidak ditemukan',
            'quantity_in_small_unit.required' => 'Jumlah satuan kecil wajib diisi',
            'quantity_in_small_unit.*.required' => 'Jumlah satuan kecil wajib diisi',
            'small_unit_id.required' => 'Satuan kecil wajib dipilih',
            'small_unit_id.exists' => 'Satuan kecil tidak ditemukan',
            'code.required' => 'Kode wajib diisi',
            'code.unique' => 'Kode sudah digunakan',
            'name.required' => 'Nama wajib diisi',
            'name.max' => 'Nama maksimal 255 karakter',
            'selling_price.required' => 'Harga jual wajib diisi',
            'selling_price.*.required' => 'Harga jual wajib diisi',
            'image.mimes' => 'Format gambar harus png, jpg, jpeg',
            'supplier_id.required' => 'Pemasok wajib dipilih',
            'supplier_id.*.exists' => 'Pemasok tidak ditemukan'
        ];
    }
}
