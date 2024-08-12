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
            'quantity_in_small_unit.*' => 'required|numeric|min:1',
            'small_unit_id' => 'required|exists:units,id',
            'code' => ['required', Rule::unique('products', 'code')->ignore($this->product)],
            'name' => 'required|max:255',
            'quantity' => 'nullable',
            'selling_price' => 'required|array',
            'selling_price.*' => 'required|numeric|min:1',
            'image' => 'nullable|mimes:png,jpg,jpeg',
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
            'quantity_in_small_unit.*.numeric' => 'Jumlah satuan kecil harus angka',
            'quantity_in_small_unit.*.min' => 'Jumlah satuan kecil minimal 1',
            'small_unit_id.required' => 'Satuan kecil wajib dipilih',
            'small_unit_id.exists' => 'Satuan kecil tidak ditemukan',
            'code.required' => 'Kode wajib diisi',
            'code.unique' => 'Kode sudah digunakan',
            'name.required' => 'Nama wajib diisi',
            'name.max' => 'Nama maksimal 255 karakter',
            'selling_price.required' => 'Harga jual wajib diisi',
            'selling_price.*.required' => 'Harga jual wajib diisi',
            'selling_price.*.numeric' => 'Harga harus angka',
            'selling_price.*.min' => 'Harga minimal 1',
            'image.mimes' => 'Format gambar harus png, jpg, jpeg',
        ];
    }

    public function prepareForValidation()
    {
        if ($this->selling_price) {
            $intArray = [];
            foreach ($this->selling_price as $value) $intArray[] = intval($value);
            $this->merge([
                'selling_price' => $intArray
            ]);
        }

        if ($this->quantity_in_small_unit) {
            $intArray = [];
            foreach ($this->quantity_in_small_unit as $value) $intArray[] = intval($value);
            $this->merge([
                'quantity_in_small_unit' => $intArray
            ]);
        }
    }
}
