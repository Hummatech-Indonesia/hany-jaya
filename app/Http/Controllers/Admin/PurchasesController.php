<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Interfaces\Admin\DetailPurchaseInterface;
use App\Contracts\Interfaces\Admin\ProductInterface;
use App\Contracts\Interfaces\Admin\ProductUnitInterface;
use App\Contracts\Interfaces\Admin\PurchaseInterface;
use App\Contracts\Interfaces\Admin\SupplierInterface;
use App\Helpers\BaseDatatable;
use App\Helpers\BaseResponse;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PurchaseRequest;
use App\Models\DetailPurchase;
use App\Models\ProductUnit;
use App\Models\Purchase;
use App\Models\User;
use App\Services\Admin\PurchaseService;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View as ViewView;

class PurchasesController extends Controller
{
    private PurchaseInterface $purchase;
    private SupplierInterface $suppliers;
    private PurchaseService $service;
    private DetailPurchaseInterface $detailPurchase;
    private ProductUnitInterface $productUnit;

    public function __construct(PurchaseInterface $purchase, SupplierInterface $suppliers,  DetailPurchaseInterface $detailPurchase, PurchaseService $service, 
    ProductUnitInterface $productUnit)
    {
        $this->purchase = $purchase;
        $this->service = $service;
        $this->detailPurchase = $detailPurchase;
        $this->suppliers = $suppliers;
        $this->productUnit = $productUnit;
    }

    /**
     * index
     *
     * @return View
     */
    public function create(): View
    {
        $suppliers = $this->suppliers->get();
        return view('dashboard.purchase.create', compact('suppliers'));
    }

    /**
     * store
     *
     * @return RedirectResponse
     */
    public function store(PurchaseRequest $request): RedirectResponse
    {
        $data =  $this->service->store($request);

        $purchase = $this->purchase->store($data);
        for ($i = 0; $i < count($data['product_id']); $i++) {
            $this->detailPurchase->store([
                'purchase_id' => $purchase->id,
                'product_id' => $data['product_id'][$i],
                'product_unit_id' => $data['product_unit_id'][$i],
                'quantity'  => $data['quantity'][$i],
                'buy_price_per_unit' => $data['buy_price_per_unit'][$i],
                'buy_price' => $data['buy_price'][$i]
            ]);
        }

        return to_route('admin.purchases.index')->with('success', trans('alert.add_success'));
    }

    /**
     * history
     *
     * @return View
     */
    public function history(Request $request): View
    {
        if ($request->daterange) {
            $array_date = explode(" - ", $request->daterange);
            $request->merge(['date' => $array_date]);
        }
        $purchases = $this->purchase->customPaginate($request, 10);
        return view('dashboard.purchase.history', compact('purchases'));
    }

    /**
     * getLast
     *
     * @param  mixed $productUnit
     * @param  mixed $user
     * @return JsonResponse
     */
    public function getLast(ProductUnit $productUnit, User $user): JsonResponse
    {
        $detailPurchase = DetailPurchase::query()->where('product_unit_id', $productUnit->id)->whereRelation('purchase', 'user_id', $user->id)->latest()->first();
        return ResponseHelper::success($detailPurchase->buy_price_per_unit);
    }

    /**
     * Get data table for data transaction purchase
     * 
     * Param for get transaction history purchase
     * findone
     * 
     * @return datatable
     */
    public function tablePurchaseHistory(Request $request)
    {
        $transaction = $this->purchase->withEloquent($request);
        return BaseDatatable::Table($transaction);
    }


    /**
     * Get data table for data transaction purchase
     * 
     * Param for get transaction history purchase
     * findone
     * 
     * @return datatable
     */
    public function dataProductLastPurchase(Request $request)
    {
        if(!$request->product_id || !$request->product_unit_id){
            return BaseResponse::Error("Field 'product_id' dan 'product_unit_id' harus diisi !");
        }

        $data = $this->detailPurchase->getWhereLast([
            "product_id" => $request->product_id
        ]);

        $harga = 0;
        if($data) {
            $purchase = $this->productUnit->getWhere([
                "product_id" => $request->product_id,
                "id" => $data->product_unit_id
            ])->first();

            $convert = $this->productUnit->getWhere([
                "product_id" => $request->product_id,
                "id" => $request->product_unit_id
            ])->first();

            $harga = ($data->buy_price_per_unit * $convert->quantity_in_small_unit / ($purchase->quantity_in_small_unit ?? 1)); 
        }

        return BaseResponse::Ok("Berhasil mengambil data", $harga);
    }
}
