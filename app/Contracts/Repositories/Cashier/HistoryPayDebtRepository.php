<?php

namespace App\Contracts\Repositories\Cashier;

use App\Contracts\Interfaces\Cashier\DebtInterface;
use App\Contracts\Interfaces\Cashier\HistoryPayDebtInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Buyer;
use App\Models\Debt;
use App\Models\HistoryPayDebt;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class HistoryPayDebtRepository extends BaseRepository implements HistoryPayDebtInterface
{
    public function __construct(HistoryPayDebt $historyPayDebt)
    {
        $this->model = $historyPayDebt;
    }
    /**
     * store
     *
     * @param  mixed $data
     * @return mixed
     */
    public function store(array $data): mixed
    {
        return $this->model->query()
            ->create($data);
    }

    /**
     * customPaginate
     *
     * @param  mixed $request
     * @param  mixed $pagination
     * @return LengthAwarePaginator
     */
    public function customPaginate(Request $request, int $pagination = 10): LengthAwarePaginator
    {
        return $this->model->query()
            ->fastPaginate($pagination);
    }

    public function with(array $data): mixed
    {
        return $this->model->with($data)->get();
    }

    /**
     * get data detail debt
     */
    public function getDetailDebt(Request $request): mixed
    {
        return $this->model->query()
        ->selectRaw('pay_debt as amount,
        created_at as date,
        "paying" as type')
        ->where('buyer_id', $request->buyer_id);
    }

    public function getSumDebt(): mixed
    {
        return $this->model->query()
        ->selectRaw(
                'buyers.id as buyer_id,
                buyers.name as buyer_name,
                buyers.address as buyer_address,
                SUM(history_pay_debts.pay_debt) as total_pay_debt'
            )
            // SUM(debts.nominal) as total_debt,
            // COALESCE(SUM(history_pay_debts.pay_debt),0) as total_pay_debt,
            // COALESCE(SUM(debts.nominal) - SUM(history_pay_debts.pay_debt),SUM(debts.nominal)) as nominal_after_check,
            // IF(COALESCE(SUM(debts.nominal) - SUM(history_pay_debts.pay_debt),SUM(debts.nominal)) > 0, "BELUM LUNAS", "LUNAS") as debt_status'
        ->leftJoin('buyers', 'history_pay_debts.buyer_id', '=', 'buyers.id')
        ->groupBy('buyers.name', 'buyers.address','buyers.id')
        ->orderBy('buyers.id','ASC')
        ->get();
    }
}
