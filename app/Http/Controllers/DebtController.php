<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\Cashier\DebtInterface;
use Illuminate\Contracts\View\View;
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
}
