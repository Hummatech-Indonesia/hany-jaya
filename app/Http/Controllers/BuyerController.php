<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\Cashier\BuyerInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class BuyerController extends Controller
{

    private BuyerInterface $buyer;

    public function __construct(BuyerInterface $buyer)
    {
        $this->buyer = $buyer;
    }

    /**
     * listDebt
     *
     * @return View
     */
    public function listDebt(Request $request): View
    {
        $buyers = $this->buyer->customPaginate($request, 5);
        return view('dashboard.debt.users.index', compact('buyers'));
    }
}
