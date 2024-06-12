<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\Cashier\DebtInterface;
use App\Enums\StatusDebt;
use App\Models\Debt;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DebtController extends Controller
{
    private DebtInterface $debt;
    public function __construct(DebtInterface $debt)
    {
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
        if ($debt->status == StatusDebt::PENDING->value) {
            $this->debt->update($debt->id, ['status' => StatusDebt::COMPLETED->value]);
        } else {
            $this->debt->update($debt->id, ['status' => StatusDebt::PENDING->value]);
        }
        return redirect()->back()->with('success', trans('alert.update_success'));
    }
}
