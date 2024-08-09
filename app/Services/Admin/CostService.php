<?php

namespace App\Services\Admin;

use App\Enums\UploadDiskEnum;
use App\Http\Requests\Admin\CostRequest;
use App\Models\Cost;
use App\Traits\UploadTrait;

class CostService
{
    use UploadTrait;

    public function store(CostRequest $request): array
    {
        $data = $request->validated();

        if (isset($data['image'])) {
            $imageUrl = $this->upload(UploadDiskEnum::PRODUCT->value, $request->file('image'));
        } else {
            $imageUrl = null;
        }

        return [
            'user_id' => auth()->user()->id,
            'desc' => $data['desc'],
            'loss_category_id' => $data['loss_category_id'],
            'price' => $data['price'],
            'image' => $imageUrl,
            'date' => $data['date']
        ];
    }

    /**
     * update
     *
     * @return array
     */
    public function update(CostRequest $request, Cost $cost): array
    {
        $data = $request->validated();

        $old_image = $cost->image;

        if ($request->hasFile('image')) {
            $this->remove($old_image);
            $old_image = $this->upload(UploadDiskEnum::COST->value, $request->file('image'));
        }

        $data = $request->validated();

        return [
            'edited_user_id' => auth()->user()->id,
            'desc' => $data['desc'],
            'loss_category_id' => $data['loss_category_id'],
            'price' => $data['price'],
            'image' => $old_image,
            'date' => $data['date'] ?? $cost->date
        ];
    }
}
