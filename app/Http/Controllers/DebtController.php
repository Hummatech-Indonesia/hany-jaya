<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\Cashier\BuyerInterface;
use App\Contracts\Interfaces\Cashier\DebtInterface;
use App\Contracts\Interfaces\Cashier\HistoryPayDebtInterface;
use App\Helpers\BaseDatatable;
use App\Http\Requests\PayDebtRequest;
use App\Models\Buyer;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DebtController extends Controller
{
    private DebtInterface $debt;
    private BuyerInterface $buyer;
    private HistoryPayDebtInterface $historyPayDebt;
    public function __construct(DebtInterface $debt, HistoryPayDebtInterface $historyPayDebt, BuyerInterface $buyer)
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

    public function show(Buyer $buyer): View
    {
        return view('dashboard.debt.show', compact('buyer'));
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
        if($buyer->debt < $request->pay_debt){
            return redirect()->back()->with('error','Uang pembayaran hutang melebihi jumlah hutang');
        }
        $this->historyPayDebt->store($data);
        $buyer->update(['debt' => $buyer->debt - intval($data['pay_debt'])]);
        return redirect()->back()->with('success', 'Sukses Membayar Hutang');
    }

    /**
     * api for datatable data debt
     * 
     * @return DataTable
     */
    public function tableDebt(Request $request)
    {
        $data = $this->debt->getSumDebt();
        return BaseDatatable::TableV2($data->toArray());
    }

    /**
     * api for datatable data debt
     * 
     * @return DataTable
     */
    public function tableDetailDebt(Request $request, Buyer $buyer)
    {
        $request->merge(["buyer_id" => $buyer->id]);
        $data1 = $this->debt->getDetailDebt($request);
        $data2 = $this->historyPayDebt->getDetailDebt($request);
        $data = $data1->union($data2)->orderBy('date','DESC')->get();

        return BaseDatatable::TableV2($data->toArray());
    }
}
