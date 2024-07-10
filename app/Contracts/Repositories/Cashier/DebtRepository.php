<?php

namespace App\Contracts\Repositories\Cashier;

use App\Contracts\Interfaces\Cashier\DebtInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Buyer;
use App\Models\Debt;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class DebtRepository extends BaseRepository implements DebtInterface
{
    public function __construct(Debt $debt)
    {
        $this->model = $debt;
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
            ->with('selling.detailSellings.product')
            ->fastPaginate($pagination);
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
     * update
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return mixed
     */
    public function update(mixed $id, array $data): mixed
    {
        return $this->model->query()
            ->findOrFail($id)
            ->update($data);
    }

     /**
     * sum
     *
     * @param  mixed $data
     * @return int
     */
    public function sum(?array $data): int
    {
        return $this->model->query()
            ->when($data, function ($query) use ($data){
                try{
                    if($data["year"]) $query->whereYear('created_at',$data["year"]);
                }catch(\Throwable $th){}
            })
            ->sum('nominal');
    }

    /**
     * get data sum
     */
    public function getSumDebt(): mixed
    {
        return $this->model->query()
        ->selectRaw(
            'buyers.name as buyer_name,
            buyers.address as buyer_address,
            SUM(sellings.amount_price) as total_debt,
            COALESCE(SUM(history_pay_debts.pay_debt),0) as total_pay_debt,
            COALESCE(SUM(sellings.amount_price) - SUM(history_pay_debts.pay_debt),SUM(sellings.amount_price)) as nominal_after_check,
            IF(COALESCE(SUM(sellings.amount_price) - SUM(history_pay_debts.pay_debt),SUM(sellings.amount_price)) > 0, "BELUM LUNAS", "LUNAS") as debt_status'
        )
        ->leftJoin('buyers', 'debts.buyer_id', '=', 'buyers.id')
        ->leftJoin('history_pay_debts', 'buyers.id', '=', 'history_pay_debts.buyer_id')
        ->leftJoin('sellings', 'debts.selling_id', '=', 'sellings.id')
        ->groupBy('buyers.name', 'buyers.address')
        ->get();
    }
}
