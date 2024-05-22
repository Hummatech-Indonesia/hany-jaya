<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Interfaces\Admin\ProductInterface;
use App\Contracts\Interfaces\Admin\PurchaseInterface;
use App\Contracts\Interfaces\Admin\SupplierInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PurchaseRequest;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View as ViewView;

class PurchasesController extends Controller
{
    private PurchaseInterface $purchase;
    private ProductInterface $product;
    private SupplierInterface $suppliers;
    public function __construct(PurchaseInterface $purchase, ProductInterface $product, SupplierInterface $suppliers)
    {
        $this->purchase = $purchase;
        $this->suppliers = $suppliers;
        $this->product = $product;
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
        $data = $request->validated();
        $product = $this->product->show($data['product_id']);

        $product->update([
            'quantity' => $product->quantity + $data['quantity']
        ]);

        $this->purchase->store($data);

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
