<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\Cashier\HistoryPayDebtInterface;
use App\Helpers\BaseDatatable;
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

    public function tablePayDebtHistory(Request $request)
    {   
        $debt = $this->historyPayDebt->with(["buyer"]);
        return BaseDatatable::TableV2($debt->toArray());
    }
}
