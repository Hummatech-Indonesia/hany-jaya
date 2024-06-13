<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\Cashier\BuyerInterface;
use App\Contracts\Interfaces\Cashier\DebtInterface;
use App\Contracts\Interfaces\Cashier\HistoryPayDebtInterface;
use App\Http\Requests\PayDebtRequest;
use App\Models\Buyer;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DebtController extends Controller
{
    private DebtInterface $debt;
    private HistoryPayDebtInterface $historyPayDebt;
    public function __construct(DebtInterface $debt, HistoryPayDebtInterface $historyPayDebt)
    {
        $this->debt = $debt;
        $this->historyPayDebt = $historyPayDebt;
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
     * payDebt
     *
     * @return RedirectResponse
     */
    public function payDebt(PayDebtRequest $request, Buyer $buyer): RedirectResponse
    {
        $data = $request->validated();
        $data['buyer_id'] = $buyer->id;
        $this->historyPayDebt->store($data);
        $buyer->update(['debt' => $buyer->debt - intval($data['pay_debt'])]);
        return redirect()->back()->with('success', 'Sukses Membayar Hutang');
    }
}
