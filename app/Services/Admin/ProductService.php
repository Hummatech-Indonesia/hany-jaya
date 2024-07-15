<?php

namespace App\Services\Admin;

use App\Enums\UploadDiskEnum;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Product;
use App\Traits\UploadTrait;

class ProductService
{
    use UploadTrait;

    public function store(ProductRequest $request): array
    {
        $data = $request->validated();

        if (isset($data['image'])) {
            $imageUrl = $this->upload(UploadDiskEnum::PRODUCT->value, $request->file('image'));
        } else {
            $imageUrl = null;
        }

        return [
            'category_id' => $data['category_id'],
            'unit_id' => $data['unit_id'],
            'code' => $data['code'],
            'name' => $data['name'],
            'quantity' => isset($data['quantity']) ? $data['quantity'] : 0,
            'image' => $imageUrl,
            'small_unit_id' => $data['small_unit_id'],
            'quantity_in_small_unit' => $data['quantity_in_small_unit'],
            'selling_price' => $data['selling_price'],
        ];
    }

    /**
     * update
     *
     * @return Returntype
     */
    public function update(ProductRequest $request, Product $product): array
    {
        $data = $request->validated();

        $old_image = $product->image;

        if ($request->hasFile('image')) {
            $this->remove($old_image);
            $old_image = $this->upload(UploadDiskEnum::PRODUCT->value, $request->file('image'));
        }
        $data = $request->validated();
        $supplier_id = null;
        try{ $supplier_id = $data["supplier_id"]; } catch(\Throwable $th){ }

        return [
            'category_id' => $data['category_id'],
            'unit_id' => $data['unit_id'],
            'code' => $data['code'],
            'name' => $data['name'],
            'quantity' => isset($data['quantity']) ? $data['quantity'] : 0,
            'image' => $old_image,
            'small_unit_id' => $data['small_unit_id'],
            'quantity_in_small_unit' => $data['quantity_in_small_unit'],
            'selling_price' => $data['selling_price'],
            'supplier_id' => $supplier_id
        ];
    }
}
