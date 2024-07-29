<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdjustmentHistoryRequest extends FormRequest
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
            'product_id' => 'required',
            'new_stock' => 'required|min:0',
            'note' => 'required'
        ];
    }

    public function message(): array
    {
        return [
            'product_id.required' => 'Produk harus di isi',
            'new_stock.required' => 'Stock baru harus di isi',
            'new_stock.min' => 'Stock baru tidak boleh dibawah 0',
            'note.required' => 'Keterangan merubah stock produk harus di isi'
        ];
    }

    public function prepareForValidation()
    {
        if($this->new_stock) $this->merge(["new_stock" => (int)$this->new_stock]);
    }
}
