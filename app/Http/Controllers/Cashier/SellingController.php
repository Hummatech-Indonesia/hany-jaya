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
use App\Helpers\UserHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cashier\SellingRequest;
use App\Services\Cashier\SellingService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SellingController extends Controller
{
    private SellingInterface $selling;
    private DebtInterface $debt;
    private ProductInterface $product;
    private ProductUnitInterface $productUnit;
    private DetailSellingInterface $detailSelling;
    private SellingService $sellingService;

    public function __construct(SellingInterface $selling, DetailSellingInterface $detailSelling, ProductInterface $product, ProductUnitInterface $productUnit, SellingService $sellingService, DebtInterface $debt)
    {
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
        return view('dashboard.selling.index');
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

        $data['amount_price'] = $serviceSellingPrice['selling_price'];
        $service = $this->sellingService->invoiceNumber($data);
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
                $this->detailSelling->store([
                    'selling_id' => $selling->id,
                    'product_id' => $data['product_id'][$i],
                    'product_unit_id' => $data['product_unit_id'][$i],
                    'quantity' => $data['quantity'][$i],
                    'selling_price' => $data['selling_price'][$i],
                    'nominal_discount' => $productUnit->selling_price - $data['selling_price'][$i]
                ]);
            }
            return to_route('cashier.selling.history')->with('success', trans('alert.add_success'));
        } else {
            return redirect()->back()->withErrors($service);
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
        }
    }
}
