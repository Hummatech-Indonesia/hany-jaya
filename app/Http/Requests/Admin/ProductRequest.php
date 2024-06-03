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
            'category_id.required' => 'The category field is required.',
            'category_id.exists' => 'The selected category is invalid.',
            'unit_id.required' => 'The unit field is required.',
            'unit_id.*.required' => 'The unit field is required.',
            'unit_id.*.exists' => 'The selected unit is invalid.',
            'quantity_in_small_unit.required' => 'The quantity in small unit field is required.',
            'quantity_in_small_unit.*.required' => 'The quantity in small unit field is required.',
            'small_unit_id.required' => 'The small unit field is required.',
            'small_unit_id.exists' => 'The selected small unit is invalid.',
            'code.required' => 'The code field is required.',
            'code.unique' => 'The code has already been taken.',
            'name.required' => 'The name field is required.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'selling_price.required' => 'The selling price field is required.',
            'selling_price.*.required' => 'The selling price field is required.',
            'image.mimes' => 'The image must be a file of type: png, jpg, jpeg.',
            'supplier_id.required' => 'The supplier field is required.',
            'supplier_id.*.exists' => 'The selected supplier is invalid.'
        ];
    }
}
