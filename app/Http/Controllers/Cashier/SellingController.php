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
use App\Helpers\BaseResponse;
use App\Helpers\UserHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cashier\SellingRequest;
use App\Services\Cashier\SellingService;
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
        $serviceSellingPrice = $this->sellingService->sellingPrice($data);

        if (is_array($serviceSellingPrice)) {
            $data['amount_price'] = $serviceSellingPrice['selling_price'];
        } else {
            return redirect()->back()->withErrors($serviceSellingPrice);
        }

        // mengecek uang pembeli tidak boleh dibawah total barang yang dibeli
        if(strtolower($data["status_payment"]) == "cash"){
            if(intval($data["pay"]) < intval($data["amount_price"])) return redirect()->back()->withErrors("Amount paying must be greather than total amount item");
        }

        // mengecek jumlah barang yang dibeli harus melebihi 0
        $check_item_qty = collect($data["quantity"])->first(function($qty) {
            return $qty <= 0;
        });
        if($check_item_qty) return redirect()->back()->withErrors("Quantity item must greather than 0");
        
        $service = $this->sellingService->invoiceNumber($data);
        DB::beginTransaction();
        try{ 
            if (is_array($service)) {
                $selling = $this->selling->store($service);
    
                if ($data['status_payment'] == StatusEnum::DEBT->value) {
                    $this->debt->store([
                        'buyer_id' => $service['buyer_id'],
                        'selling_id' => $selling->id,
                        'nominal' => $serviceSellingPrice['selling_price']
                    ]);
                }
    
                for ($i = 0; $i < count($data['product_id']); $i++) {
                    $serviceSellingPrice['product']->update([
                        'quantity' => $serviceSellingPrice['product']->quantity - $serviceSellingPrice['quantity']
                    ]);
                    $productUnit = $this->productUnit->show($data['product_unit_id'][$i]);
                    $test = $this->detailSelling->store([
                        'selling_id' => $selling->id,
                        'product_id' => $data['product_id'][$i],
                        'product_unit_price' => $productUnit->selling_price,
                        'product_unit_id' => $data['product_unit_id'][$i],
                        'quantity' => $data['quantity'][$i],
                        'selling_price' => $data['selling_price'][$i],
                        'nominal_discount' => intval($productUnit->selling_price * $data["quantity"][$i]) - intval($data['selling_price'][$i]),
                        'selling_price_original' => $productUnit->selling_price
                    ]);
                }

                DB::commit();
                return to_route('cashier.selling.history')->with('success', trans('alert.add_success'));
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
        if (UserHelper::getUserRole() == RoleEnum::ADMIN->value) {
            return view('dashboard.selling.history', compact('histories'));
        } elseif (UserHelper::getUserROle() == RoleEnum::CASHIER->value) {
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
            $buyer = $this->buyer->getWhere([
                'name' => $request->buyer_name,
                'address' => $request->buyer_address
            ]);

            if(!$buyer) return BaseResponse::Error("Pembeli tidak ditemukan");
            else $request["buyer_id"] = $buyer->id;
        }

        $transaction = $this->selling->findTransactionByProductAndUser($request);

        if($transaction) {
            $transaction = $transaction?->detailSellings[0];
        }

        return BaseResponse::Ok("Berhasil megambil data history transaction",$transaction);
    }
}
