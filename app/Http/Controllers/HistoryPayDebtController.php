<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\Cashier\HistoryPayDebtInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HistoryPayDebtController extends Controller
{
    private HistoryPayDebtInterface $historyPayDebt;
    public function __construct(HistoryPayDebtInterface $historyPayDebt)
    {
        $this->historyPayDebt = $historyPayDebt;
    }

    public function index(Request $request): View
    {
        $historyPayDebts = $this->historyPayDebt->customPaginate($request);
        return view('dashboard.debt.history-pay-debt.index', compact('historyPayDebts'));
    }
}
