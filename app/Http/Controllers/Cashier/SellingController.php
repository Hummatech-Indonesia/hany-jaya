<?php

namespace App\Http\Controllers\Cashier;

use App\Contracts\Interfaces\Admin\ProductInterface;
use App\Contracts\Interfaces\Admin\ProductUnitInterface;
use App\Contracts\Interfaces\Cashier\BuyerInterface;
use App\Contracts\Interfaces\Cashier\DebtInterface;
use App\Contracts\Interfaces\Cashier\DetailSellingInterface;
use App\Contracts\Interfaces\Cashier\SellingInterface;
use App\Enums\RoleEnum;
use App\Enums\StatusEnum;
use App\Helpers\BaseDatatable;
use App\Helpers\BasePrint;
use App\Helpers\BaseResponse;
use App\Helpers\UserHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cashier\SellingRequest;
use App\Services\Cashier\SellingService;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SellingController extends Controller
{
    private SellingInterface $selling;
    private DebtInterface $debt;
    private ProductInterface $product;
    private ProductUnitInterface $productUnit;
    private DetailSellingInterface $detailSelling;
    private BuyerInterface $buyer;
    private SellingService $sellingService;

    public function __construct(SellingInterface $selling, DetailSellingInterface $detailSelling, ProductInterface $product, ProductUnitInterface $productUnit, SellingService $sellingService, DebtInterface $debt, BuyerInterface $buyer)
    {
        $this->buyer = $buyer;
        $this->selling = $selling;
        $this->debt = $debt;
        $this->product = $product;
        $this->productUnit = $productUnit;
        $this->detailSelling = $detailSelling;
        $this->sellingService = $sellingService;
    }

    /**
     * create
     *
     * @return View
     */
    public function create(): View
    {
        $buyers = $this->buyer->get();
        $products = $this->product->get();
        return view('dashboard.selling.index', compact('buyers', 'products'));
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return RedirectResponse
     */
    public function store(SellingRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data["debt"] = $request->debt;

        // checking value buyer name
        if(strpos($data["name"],'-')) {
            try{
                $data["name"] = explode('-', $data["name"])[0];
            }catch(\Throwable $th){
                $data["name"] = $data["name"];
            }
        }

        // default value for status_payment
        if(is_array($data["status_payment"])){
            if(count($data["status_payment"]) == 1) $data["status_payment"] = $data["status_payment"][0];
            else $data["status_payment"] = StatusEnum::CASH->value;
        }else {
            $data["status_payment"] = StatusEnum::CASH->value;
        }
              
        $serviceSellingPrice = $this->sellingService->sellingPrice($data);

        if (is_array($serviceSellingPrice)) {
            $data['amount_price'] = $serviceSellingPrice['selling_price'];
        } else {
            return redirect()->back()->withErrors($serviceSellingPrice);
        }

        // mengecek jumlah barang yang dibeli harus melebihi 0
        $check_item_qty = collect($data["quantity"])->first(function($qty) {
            return $qty <= 0;
        });
        if($check_item_qty) return redirect()->back()->withErrors("Quantity item must greather than 0");
        
        DB::beginTransaction();
        try{ 
            $service = $this->sellingService->invoiceNumber($data);
            if (is_array($service)) {
                $selling = $this->selling->store($service);
    
                $debt_price = 0;
                if ($service['status_payment'] == StatusEnum::DEBT->value) {
                    $debt_price = $serviceSellingPrice["selling_price"];
                    $this->debt->store([
                        'buyer_id' => $service['buyer_id'],
                        'selling_id' => $selling->id,
                        'nominal' => $serviceSellingPrice['selling_price']
                    ]);
                }

                if($service["status_payment"] == StatusEnum::SPLIT->value) {
                    $debt_price = $service["debt"];
                    $this->debt->store([
                        'buyer_id' => $service['buyer_id'],
                        'selling_id' => $selling->id,
                        'nominal' => $service["debt"] ?? 0
                    ]);
                }
    
                $details = [
                    "invoice_number" => $service["invoice_number"],
                    "total_price" => $selling->amount_price,
                    "pay_price" => $selling->pay,
                    "return_price" => $selling->return,
                    "total_debt_price" => $debt_price,
                    "buyer_name" => $data["name"],
                    "date" => Carbon::parse($selling->created_at)->format("DD MMMM Y"),
                    "details" => [],
                ];

                for ($i = 0; $i < count($data['product_id']); $i++) {
                    $serviceSellingPrice['product']->update([
                        'quantity' => $serviceSellingPrice['product']->quantity - $serviceSellingPrice['quantity']
                    ]);
                    $productUnit = $this->productUnit->show($data['product_unit_id'][$i]);
                    $this->detailSelling->store([
                        'selling_id' => $selling->id,
                        'product_id' => $data['product_id'][$i],
                        'product_unit_price' => ($data['selling_price'][$i] / $data['quantity'][$i]),
                        'product_unit_id' => $data['product_unit_id'][$i],
                        'quantity' => $data['quantity'][$i],
                        'selling_price' => $data['selling_price'][$i],
                        'nominal_discount' => intval($productUnit->selling_price * $data["quantity"][$i]) - intval($data['selling_price'][$i]),
                        'selling_price_original' => $productUnit->selling_price
                    ]);

                    $details["details"][] = [
                        "name" => $productUnit->product->name. " (". $productUnit->unit->name . ")",
                        "qty" => $data['quantity'][$i],
                        "price" => ($data['selling_price'][$i] / $data['quantity'][$i])
                    ];
                }

                DB::commit();
                $printed = BasePrint::mikePrint($details);
                if($printed["success"]){
                    return to_route('cashier.index')->with('success', trans('alert.add_success'));
                } else {
                    return to_route('cashier.index')->with('success', 'Berhasil menjual, tetapi mohon maaf tidak bisa melakukan print saat ini!');
                }
            } else {
                DB::rollBack();
                return redirect()->back()->withErrors($service);
            }
        }catch(\Throwable $th){
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }


    /**
     * history
     *
     * @param  mixed $request
     * @return View
     */
    public function history(Request $request): View
    {
        $histories = $this->selling->customPaginate($request);
        if (auth()->user()->hasRole(RoleEnum::ADMIN->value)) {
            return view('dashboard.selling.history', compact('histories'));
        } elseif (auth()->user()->hasRole(RoleEnum::CASHIER->value)) {
            return view('dashboard.selling.cashier-history', compact('histories'));
        } else {
            return view('dashboard.selling.history', compact('histories'));
        }
    }
    /**
     * Method adminHistory
     *
     * @param Request $request [explicite description]
     *
     * @return View
     */
    public function adminSellingHistory(Request $request): View
    {
        $histories = $this->selling->customPaginate($request);
        return view('dashboard.selling.cashier-history', compact('histories'));
    }

    /**
     * Get User for api
     * 
     * Param search for query LIKE
     * ?search
     * 
     * @return #list buyer
     */
    public function listBuyer(Request $request)
    {
        $buyer = $this->buyer->getBuyer($request);

        return BaseResponse::Ok("Berhasil mengambil list data pembeli",$buyer);
    }

    /**
     * Get User history transaction for api
     * 
     * Param for get history transaction
     * findone
     * 
     * @return #list buyer
     */
    public function dataUserTransactionHistoryLatest(Request $request)
    {
        if(!$request->buyer_id)
        {
            // checking value buyer name
            if(strpos($request->buyer_name,'-')) {
                $name = "";
                try{
                    $name = explode('-', $request->buyer_name)[0];
                }catch(\Throwable $th){
                    $name = $request->buyer_name;
                }
            }

            $buyer = $this->buyer->getWhere([
                'name' => $name,
                'address' => $request->buyer_address
            ]);

            if(!$buyer) return BaseResponse::Error("Pembeli tidak ditemukan");
            else $request["buyer_id"] = $buyer->id;
        }

        $transaction = $this->selling->findTransactionByProductAndUser($request);

        if($transaction) {
            $transaction = $transaction?->detailSellings[0];
            $transaction->selling_price_original = $transaction->selling_price;
            $transaction->selling_price = $transaction->selling_price / $transaction->quantity;
        }

        return BaseResponse::Ok("Berhasil megambil data history transaction",$transaction);
    }

    /**
     * Get data table for data transaction history
     * 
     * Param for get history transaction
     * findone
     * 
     * @return datatable
     */
    public function tableTransactionHistory(Request $request)
    {
        $transaction = $this->selling->withEloquent($request)->get();
        return BaseDatatable::TableV2($transaction->toArray());
    }

    /**
     * Get data table for data transaction history
     * 
     * Param for get history transaction
     * findone
     * 
     * @return datatable
     */
    public function tableUserHighTransaction(Request $request)
    {
        $transaction = $this->selling->withEloquent($request)->get();

        $data = $this->sellingService->highTransaction($transaction->toArray(), 5);
        return BaseDatatable::TableV2($data);
    }    

     /**
     * Get data table for data debt history
     * 
     * Param for get debt transaction
     * findone
     * 
     * @return datatable
     */
    public function tableDebtHistory(Request $request)
    {
        $transaction = $this->debt->with(["buyer", "selling" => function($query) {
            $query->with(['detailSellings' => function ($query2){
                $query2->with(["productUnit" => function ($query3){
                    $query3->with('unit');
                }, 'product']);
            }]);
        }]);
        return BaseDatatable::TableV2($transaction->toArray());
    }

    public function printed()
    {
        BasePrint::mikePrint([]);
        return "YEY PRINT";
    }
}
