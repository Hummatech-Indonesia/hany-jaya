<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'supplier_id' => $this->supplier_id,
            'supplier' => $this->supplier->name,
            'product_id' => $this->product_id,
            'product' => $this->product->name,
        ];
    }
}
