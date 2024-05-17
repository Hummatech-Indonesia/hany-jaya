<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Interfaces\Admin\ProductInterface;
use App\Contracts\Interfaces\Admin\PurchaseInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PurchaseRequest;
use Illuminate\Contracts\View\View;
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
     * index
     *
     * @return View
     */
    public function create(): View
    {
        $products = $this->product->get();
        return view('dashboard.purchase.create', compact('products'));
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

        return redirect()->back()->with('success', trans('alert.add_success'));
    }
}
