<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ReturnItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'selling_id' => 'required',
            'detail_selling_id' => 'required',
            'note' => 'required',
            'qty_return' => 'required|array',
            'qty_return.*' => 'numeric|min:0'
        ];
    }

    public function message(): array
    {
        return [
            'selling_id.required' => 'Data penjualan harus diisikan',
            'detail_selling_id' => 'Data detail penjualan harus diisikan',
            'note' => 'Deskripsi nota harus diisikan',
            'qty_return' => 'Jumlah barang yang dikembalikan harus diisikan',
            'qty_return.*.numeric' => 'Jumlah barang yang dikembalikan harus berupa angka',
            'qty_return.*.min' => 'Jumlah barang yang dikembalikan tidak boleh dibawah 0'
        ];
    }

    public function prepareForValidation()
    {
        if($this->selling_detail_id) $this->merge(['detail_selling_id' => $this->selling_detail_id]);
    }
}
