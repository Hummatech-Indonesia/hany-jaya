<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Interfaces\Admin\ProductInterface;
use App\Contracts\Interfaces\Admin\PurchaseInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PurchaseRequest;
use Illuminate\Http\RedirectResponse;

class PurchasesController extends Controller
{
    private PurchaseInterface $purchase;
    private ProductInterface $product;
    public function __construct(PurchaseInterface $purchase, ProductInterface $product)
    {
        $this->purchase = $purchase;
        $this->product = $product;
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
            'quantity' => $product->quantity + 1
        ]);

        $this->purchase->store($data);

        return redirect()->back()->with('success', trans('alert.add_success'));
    }
}
