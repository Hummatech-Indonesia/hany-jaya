<?php

namespace App\Services\Cashier;

use App\Contracts\Interfaces\Cashier\BuyerInterface;
use App\Contracts\Interfaces\Cashier\SellingInterface;

class SellingService
{
    private SellingInterface $selling;
    private BuyerInterface $buyer;
    public function __construct(SellingInterface $selling, BuyerInterface $buyer)
    {
        $this->selling = $selling;
        $this->buyer = $buyer;
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
}
