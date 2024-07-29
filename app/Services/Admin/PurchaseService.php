<?php

namespace App\Services\Admin;

use App\Contracts\Interfaces\Admin\ProductInterface;
use App\Contracts\Interfaces\Admin\ProductUnitInterface;
use App\Http\Requests\Admin\PurchaseRequest;

class PurchaseService
{

    private ProductInterface $product;
    private ProductUnitInterface $productUnit;
    public function __construct(ProductUnitInterface $productUnit, ProductInterface $product)
    {
        $this->product = $product;
        $this->productUnit = $productUnit;
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return array
     */
    public function store(PurchaseRequest $request): array
    {
        $data = $request->validated();
        $data['total_buy_price'] = 0;
        for ($i = 0; $i < count($data['product_id']); $i++) {
            $product = $this->product->show($data['product_id'][$i]);

            $productUnit = $this->productUnit->show($data['product_unit_id'][$i]);
            $quantity = $productUnit->quantity_in_small_unit * $data['quantity'][$i];

            $product->update([
                'quantity' => $product->quantity + $quantity
            ]);

            $data['total_buy_price'] += $data['buy_price'][$i];
        }

        return $data;
    }

    public function sumPriceWithConvert() : float
    {
        return 0;
    }
}
