<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\Cashier\BuyerInterface;
use App\Contracts\Interfaces\Cashier\DebtInterface;
use App\Enums\StatusDebt;
use App\Models\Debt;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DebtController extends Controller
{
    private DebtInterface $debt;
    private BuyerInterface $buyer;
    public function __construct(DebtInterface $debt, BuyerInterface $buyer)
    {
        $this->buyer = $buyer;
        $this->debt = $debt;
    }

    /**
     * index
     *
     * @return View
     */
    public function index(Request $request): View
    {
        $debts = $this->debt->customPaginate($request);
        return view('dashboard.debt.index', compact('debts'));
    }

    /**
     * update
     *
     * @return RedirectResponse
     */
    public function rolling(Debt $debt): RedirectResponse
    {
        $buyer = $this->buyer->show($debt->buyer_id);
        if ($debt->status == StatusDebt::PENDING->value) {
            $buyer->update(['debt' => $buyer->debt - 1]);
            $this->debt->update($debt->id, ['status' => StatusDebt::COMPLETED->value]);
        } else {
            $buyer->update(['debt' => $buyer->debt + 1]);
            $this->debt->update($debt->id, ['status' => StatusDebt::PENDING->value]);
        }
        return redirect()->back()->with('success', trans('alert.update_success'));
    }
}
