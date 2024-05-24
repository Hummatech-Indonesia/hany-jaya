<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Interfaces\Admin\DetailPurchaseInterface;
use App\Contracts\Interfaces\Admin\ProductInterface;
use App\Contracts\Interfaces\Admin\ProductUnitInterface;
use App\Contracts\Interfaces\Admin\PurchaseInterface;
use App\Contracts\Interfaces\Admin\SupplierInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PurchaseRequest;
use App\Services\Admin\PurchaseService;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View as ViewView;

class PurchasesController extends Controller
{
    private PurchaseInterface $purchase;
    private SupplierInterface $suppliers;
    private PurchaseService $service;
    private DetailPurchaseInterface $detailPurchase;
    public function __construct(PurchaseInterface $purchase, SupplierInterface $suppliers,  DetailPurchaseInterface $detailPurchase, PurchaseService $service)
    {
        $this->purchase = $purchase;
        $this->service = $service;
        $this->detailPurchase = $detailPurchase;
        $this->suppliers = $suppliers;
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
}
