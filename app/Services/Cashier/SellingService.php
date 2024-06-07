<?php

namespace App\Services\Cashier;

use App\Contracts\Interfaces\Admin\ProductInterface;
use App\Contracts\Interfaces\Admin\ProductUnitInterface;
use App\Contracts\Interfaces\Cashier\BuyerInterface;
use App\Contracts\Interfaces\Cashier\SellingInterface;

class SellingService
{
    private SellingInterface $selling;
    private BuyerInterface $buyer;
    private ProductUnitInterface $productUnit;
    private ProductInterface $product;
    public function __construct(SellingInterface $selling, BuyerInterface $buyer, ProductUnitInterface $productUnit, ProductInterface $product)
    {
        $this->selling = $selling;
        $this->buyer = $buyer;
        $this->product = $product;
        $this->productUnit = $productUnit;
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return array
     */
    public function invoiceNumber(array $data): array
    {
        $getYear = substr(now()->format('Y'), -2);

        $selling_invoice = $this->selling->get();
        if ($selling_invoice) {
            $invoice_number = substr($selling_invoice->invoice_number, -4);
            $invoice_number = intval($invoice_number);
            $integer = $invoice_number + 1;
            $length = 4;
            $invoice_number = str_pad(intval($integer), $length, "0", STR_PAD_LEFT);
            $external_id = "KLHM" . $getYear . $invoice_number;
        } else {
            $external_id = "KLHM" . $getYear . "0001";
        }

        $data['invoice_number'] = $external_id;
        $buyer = $this->buyer->getWhere(['name' => $data['name'], 'address' => $data['address']]);
        if ($buyer == null) {
            $data['buyer_id'] = $this->buyer->store(['name' => $data['name'], 'address' => $data['address']])->id;
        } else {
            $data['buyer_id'] = $buyer->id;
        }
        return $data;
    }

    public function sellingPrice(array $data)
    {
        $sellingPrice = 0;

        for ($i = 0; $i < count($data['selling_price']); $i++) {
            $sellingPrice += $data['selling_price'][$i];
            $productUnit = $this->productUnit->show($data['product_unit_id'][$i]);
            $quantity = $productUnit->quantity_in_small_unit * $data['quantity'][$i];
            $product = $this->product->show($data['product_id'][$i]);

            if ($product->quantity < $quantity) {
                return redirect()->back()->withErrors('Stok tidak mencukupi');
            }
        }
        return [
            'selling_price' => $sellingPrice,
            'product_unit' => $productUnit,
            'quantity' => $quantity,
            'product' => $product
        ];
    }
}
