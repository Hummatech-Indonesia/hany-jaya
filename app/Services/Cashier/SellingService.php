<?php

namespace App\Services\Cashier;

use App\Contracts\Interfaces\Admin\ProductInterface;
use App\Contracts\Interfaces\Admin\ProductUnitInterface;
use App\Contracts\Interfaces\Cashier\BuyerInterface;
use App\Contracts\Interfaces\Cashier\DebtInterface;
use App\Contracts\Interfaces\Cashier\SellingInterface;
use App\Enums\StatusEnum;
use Illuminate\Http\RedirectResponse;
use stdClass;

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
    public function invoiceNumber(array $data): array|string
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
        $buyer = $this->buyer->getWhere(['name' => $data['name']]);
        $sellingPrice = 0;
        for ($i = 0; $i < count($data['selling_price']); $i++) {
            $sellingPrice += $data['selling_price'][$i];
        }

        if ($buyer == null) {
            if ($data['status_payment'] == StatusEnum::DEBT->value) {
                if (auth()->user()->store->code_debt == $data['code_debt']) {
                    $data['buyer_id'] = $this->buyer->store(['name' => $data['name'], 'address' => $data['address'], 'debt' => $sellingPrice])->id;
                } else {
                    return 'inputkan kode toko dengan benar jika ingin melakukan hutang';
                }
            } else {
                $data['buyer_id'] = $this->buyer->store(['name' => $data['name'], 'address' => $data['address']])->id;
            }
        } else {
            if ($data['status_payment'] == StatusEnum::DEBT->value) {
                if (auth()->user()->store->code_debt == $data['code_debt']) {
                    $buyer->update(['debt' => $buyer->debt + $sellingPrice]);
                } else {
                    return 'inputkan kode toko dengan benar jika ingin melakukan hutang';
                }
            }
            $data['buyer_id'] = $buyer->id;
        }
        return $data;
    }

    /**
     * sellingPrice
     *
     * @param  mixed $data
     * @return void
     */
    public function sellingPrice(array $data)
    {
        $sellingPrice = 0;

        for ($i = 0; $i < count($data['selling_price']); $i++) {
            $sellingPrice += $data['selling_price'][$i];
            $productUnit = $this->productUnit->show($data['product_unit_id'][$i]);
            $quantity = $productUnit->quantity_in_small_unit * $data['quantity'][$i];
            $product = $this->product->show($data['product_id'][$i]);

            if ($product->quantity < $quantity) {
                return 'Stok tidak mencukupi';
            }
        }
        return [
            'selling_price' => $sellingPrice,
            'product_unit' => $productUnit,
            'quantity' => $quantity,
            'product' => $product
        ];
    }

    /**
     * Function for get data high transaction
     * @param array $data | integer $take
     */
    public function highTransaction(array $data, ?int $take = null): array
    {
        $array = [];
        
        collect($data)->each(function ($item) use (&$array) {
            $item = (object) $item;
            $item->buyer = (object) $item->buyer;
            
            $selected = collect($array)->first(function ($value) use ($item) { 
                return $value->name == $item->buyer->name && $value->address == $item->buyer->address; 
            });
            
            if ($selected) {
                $selected->total_price += $item->amount_price;
                $selected->total_transaction += 1;
            } else {
                $selectedData = new stdClass();
                $selectedData->name = $item->buyer->name;
                $selectedData->address = $item->buyer->address;
                $selectedData->total_price = $item->amount_price;
                $selectedData->total_transaction = 1;
                $array[] = $selectedData;
            }
        });
        
        // Sort the array by total_price in descending order
        usort($array, function ($a, $b) {
            return $b->total_price <=> $a->total_price;
        });
        
        // Limit the results if $take is provided
        if ($take !== null) {
            $array = array_slice($array, 0, $take);
        }
        
        return $array;
    }
}
