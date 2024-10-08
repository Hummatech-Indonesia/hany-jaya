<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\Cashier\BuyerInterface;
use App\Contracts\Interfaces\Cashier\DebtInterface;
use App\Contracts\Interfaces\Cashier\HistoryPayDebtInterface;
use App\Helpers\BaseDatatable;
use App\Http\Requests\PayDebtRequest;
use App\Models\Buyer;
use App\Services\Cashier\DebtService;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DebtController extends Controller
{
    private DebtInterface $debt;
    private BuyerInterface $buyer;
    private HistoryPayDebtInterface $historyPayDebt;
    private DebtService $debtService;

    public function __construct(DebtInterface $debt, HistoryPayDebtInterface $historyPayDebt, BuyerInterface $buyer, DebtService $debtService)
    {
        $this->debt = $debt;
        $this->historyPayDebt = $historyPayDebt;
        $this->buyer = $buyer;
        $this->debtService = $debtService;
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

        $debts = $this->debt->getWhereV2(['buyer_id' => $buyer->id, 'paid_off' => 0]);
        $date_limit = null;
        
        $pay_debt = $request->pay_debt;

        DB::beginTransaction();
        try{ 
            foreach($debts as $debt){
                if(($debt->remind_debt - $pay_debt) < 0){
                    $pay_debt -= $debt->remind_debt;
                    $debt->update(['paid_off' => 1, 'remind_debt' => 0]);
                }else if(($debt->remind_debt - $pay_debt) == 0){
                    $debt->update(['paid_off' => 1, 'remind_debt' => 0]);
                }else {
                    $debt->update(['remind_debt' => $debt->remind_debt - $pay_debt]);
                    $date_limit = Carbon::parse($debt->created_at)
                    ->addDays($buyer->limit_time_debt ?? 30)
                    ->format('Y-m-d');
                    break;
                }
            }
    
            $this->historyPayDebt->store($data);
            $buyer->update(['debt' => $buyer->debt - $request->pay_debt, 'limit_date_debt' => $date_limit]);
       
            DB::commit();
            return redirect()->back()->with('success', 'Sukses Membayar Hutang');
        }catch(\Throwable $th){
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal dalam membayar hutang dengan error => '.$th->getMessage());
        }
    }

    /**
     * api for datatable data debt
     * 
     * @return DataTable
     */
    public function tableDebt(Request $request)
    {
        $data1 = $this->debt->getSumDebt();
        $data2 = $this->historyPayDebt->getSumDebt();

        $data = $this->debtService->checkDebtUser($data1, $data2);
        return BaseDatatable::TableV2($data);
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
