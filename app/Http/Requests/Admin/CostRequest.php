<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CostRequest extends FormRequest
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
            'user_id' => 'nullable',
            'edited_user_id' => 'nullable',
            'desc' => 'required',
            'loss_category_id' => 'required',
            'price' => 'required|numeric|min:0',
            'date' => 'nullable',
            'image' => 'nullable'
        ];
    }

    public function messages()
    {
        return [
            'desc.required' => 'Keterangan harus diisi',
            'loss_category_id.required' => 'Kategori harus diisi',
            'price.required' => 'Jumlah pengeluaran harus diisi',
            'price.numeric' => 'Pengelaran harus berupa angka',
            'price.min' => 'Jumlah pengeluaran harus diatas 0' 
        ];
    }

    public function prepareForValidation()
    {
        if(!$this->date) $this->merge(["date" => null]);
    }
}
