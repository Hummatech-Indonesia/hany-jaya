<?php

namespace App\Http\Controllers\Cashier;

use App\Contracts\Interfaces\Admin\ProductInterface;
use App\Contracts\Interfaces\Admin\ProductUnitInterface;
use App\Contracts\Interfaces\Cashier\DetailSellingInterface;
use App\Contracts\Interfaces\Cashier\SellingInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cashier\SellingRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SellingController extends Controller
{
    private SellingInterface $selling;
    private ProductInterface $product;
    private ProductUnitInterface $productUnit;
    private DetailSellingInterface $detailSelling;

    public function __construct(SellingInterface $selling, DetailSellingInterface $detailSelling, ProductInterface $product, ProductUnitInterface $productUnit)
    {
        $this->selling = $selling;
        $this->product = $product;
        $this->productUnit = $product;
        $this->detailSelling = $detailSelling;
    }

    public function create(): View
    {
        return view('dashboard.selling.create');
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

        $sellingPrice = 0;
        for ($i = 0; $i < $data['product_id']; $i++) {
            $product = $this->product->show($data['product_id'][$i]);
            $productUnit = $this->productUnit->show($data['product_unit_id'][$i]);
            $product->update([
                'quantity' => $product->quantity - $productUnit->quantity_in_small_unit * $data['quantity'][$i]
            ]);
            $this->detailSelling->store([
                'selling_id' => $data['selling_id'][$i],
                'product_id' => $data['product_id'][$i],
                'product_unit_id' => $data['product_unit_id'][$i],
                'quantity' => $data['quantity'][$i],
                'selling_price' => $data['selling_price'][$i]
            ]);
            $sellingPrice += $data['selling_price'][$i];
        }
        $data['amount_price'] = $sellingPrice;
        $this->selling->store($data);
        return redirect()->back()->with('success', trans('alert.add_success'));
    }
}
