<?php

namespace App\Services\Cashier;

use App\Contracts\Interfaces\Admin\ProductInterface;
use App\Contracts\Interfaces\Admin\ProductUnitInterface;
use App\Contracts\Interfaces\Cashier\BuyerInterface;
use App\Contracts\Interfaces\Cashier\DebtInterface;
use App\Contracts\Interfaces\Cashier\SellingInterface;
use App\Enums\StatusEnum;
use App\Models\Store;
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
        $getDate = now()->format('md');
        $number_default = $getYear.$getDate;

        //limit for default debt
        $limit_debt = 10000000;
        $limit_time_debt = 30;
        $limit_date_debt = now()->addDays($limit_time_debt);
        
        $check_code_debt = false;
        $code_debt = null;
        try{ 
            $code_debt = Store::where('code_debt',$data['code_debt'])->first();
            $code_debt = $data['code_debt'];
            if($code_debt) $check_code_debt = true;
        }catch(\Throwable $th){ }


        $selling_invoice = $this->selling->getInvoice();
        
        if ($selling_invoice) {
            if(strpos($selling_invoice->invoice, $number_default) == 0){
                $invoice_number = substr($selling_invoice->invoice, -4);
    
                $length = strlen($invoice_number);

                $invoice_number = intval($invoice_number);
                $integer = $invoice_number + 1;
                $invoice_number = str_pad(intval($integer), $length, "0", STR_PAD_LEFT);
                
                $external_id = "HNJY" . $number_default . $invoice_number;
            }else {
                $external_id = "HNJY" . $number_default . "0001";
            }
        } else {
            $external_id = "HNJY" . $number_default . "0001";
        }

        $data['invoice_number'] = $external_id;
        $buyer = $this->buyer->getWhere(['name' => $data['name'], 'address' => $data['address']]);
        $sellingPrice = 0;
        for ($i = 0; $i < count($data['selling_price']); $i++) {
            $sellingPrice += $data['selling_price'][$i];
        }

        $data["success"] = true;
        $data["message"] = "";

        if ($buyer == null) {
            $telp = null; 
            $code = null; 
            try{ 
                $telp = $data["telp"];
                $code = $data["code"];
            }catch(\Throwable $th){ }

            if ($data['status_payment'] == StatusEnum::DEBT->value) {
                $buyer = $this->buyer->store(['name' => $data['name'], 'address' => $data['address'], 'telp' => $telp, 'code' => $code, 'debt' => $sellingPrice, 'limit_debt' => $limit_debt, 'limit_date_debt' => $limit_date_debt, 'limit_time_debt' => $limit_time_debt]);
            } else {
                $buyer = $this->buyer->store(['name' => $data['name'], 'address' => $data['address'], 'telp' => $telp, 'code' => $code]);
            }

            $data["buyer_id"] = $buyer->id;
        } else {
            
            if ($data['status_payment'] == StatusEnum::DEBT->value) {
                $check_limit_total = ($buyer->debt + $sellingPrice) > $buyer->limit_debt && $buyer->limit_debt != 0;
                $check_limit_date = ($buyer->limit_date_debt ? date('Y-m-d', strtotime($buyer->limit_date_debt)) : date('Y-m-d')) < date('Y-m-d');
                if($check_limit_total || $check_limit_date){
                    if(!$code_debt){
                        $data['success'] = false;
                        $data['message'] = "Tidak dapat melakukan transaksi, karena pembeli telah mencapai limit hutangnya!";
                    } 

                    if(!$check_code_debt) {
                        $data['success'] = false;
                        $data['message'] = "Kode toko yang diajukan tidak sesuai silahkan cek kembali kode tokonya untuk melakukan transaksi pembeli!";
                    }
                    else $data['success'] = true;
                }
                else $data['success'] = true;

                $payload = ['debt' => $buyer->debt + $sellingPrice, 'limit_debt' => $limit_debt, 'limit_date_debt' => $limit_date_debt, 'limit_time_debt' => $limit_time_debt];
                if($buyer->limit_debt) unset($payload['limit_debt']);
                if($buyer->limit_time_debt) unset($payload['limit_time_debt']);
                if($buyer->limit_date_debt) unset($payload['limit_date_debt']);
                
                $buyer->update($payload);
            }
            

            $data['buyer_id'] = $buyer->id;
        }
        $pay = 0;
        
        if($data['status_payment'] == StatusEnum::SPLIT->value) {
            if((int)($data["debt"] ?? 0) > 0){
                $check_limit_total = ($buyer->debt + $sellingPrice) > $buyer->limit_debt && $buyer->limit_debt != 0;
                $check_limit_date = ($buyer->limit_date_debt ? date('Y-m-d', strtotime($buyer->limit_date_debt)) : date('Y-m-d')) < date('Y-m-d');

                if($check_limit_total || $check_limit_date){
                    if(!$code_debt){
                        $data['success'] = false;
                        $data['message'] = "Tidak dapat melakukan transaksi, karena pembeli telah mencapai limit hutangnya!";
                    } 

                    if(!$check_code_debt) {
                        $data['success'] = false;
                        $data['message'] = "Kode toko yang diajukan tidak sesuai silahkan cek kembali kode tokonya untuk melakukan transaksi pembeli!";
                    }
                    else $data['success'] = true;
                }else $data['success'] = true;

                $payload = ['debt' => $buyer->debt + ($data["debt"] ?? 0), 'limit_debt' => $limit_debt, 'limit_date_debt' => $limit_date_debt, 'limit_time_debt' => $limit_time_debt];
                if($buyer->limit_debt) unset($payload['limit_debt']);
                if($buyer->limit_time_debt) unset($payload['limit_time_debt']);
                if($buyer->limit_date_debt) unset($payload['limit_date_debt']);

                $buyer->update($payload);
            }else {
                $data["status_payment"] = StatusEnum::CASH->value;
            }
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

        $products = [];
        $quantitys = [];
        for ($i = 0; $i < count($data['selling_price']); $i++) {
            $sellingPrice += $data['selling_price'][$i];
            $productUnit = $this->productUnit->show($data['product_unit_id'][$i]);
            $quantity = $productUnit->quantity_in_small_unit * $data['quantity'][$i];
            $product = $this->product->show($data['product_id'][$i]);

            if ($product->quantity < $quantity) {
                return 'Stok tidak mencukupi';
            }

            $products[] = $product;
            $quantitys[] = $quantity;
        }
        return [
            'selling_price' => $sellingPrice,
            'product_unit' => $productUnit,
            'quantity' => $quantitys,
            'product' => $products
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

    /**
     * Function for minus quantity
     * 
     */
    public function sumQuantity()
    {

    }
}
