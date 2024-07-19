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
     * getWhere
     *
     * @param  mixed $data
     * @return mixed
     */
    public function get(): mixed
    {
        return $this->model->query()->get();
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
     * Get realtion data in this model
     */
    public function with(array $data): mixed
    {
        return $this->model->query()->with($data)->get();
    }

    /**
     * get data sum
     */
    public function getSumDebt(): mixed
    {
        return $this->model->query()
        ->selectRaw(
                'buyers.id as buyer_id,
                buyers.name as buyer_name,
                buyers.address as buyer_address,
                SUM(debts.nominal) as total_debt'
            )
            // SUM(debts.nominal) as total_debt,
            // COALESCE(SUM(history_pay_debts.pay_debt),0) as total_pay_debt,
            // COALESCE(SUM(debts.nominal) - SUM(history_pay_debts.pay_debt),SUM(debts.nominal)) as nominal_after_check,
            // IF(COALESCE(SUM(debts.nominal) - SUM(history_pay_debts.pay_debt),SUM(debts.nominal)) > 0, "BELUM LUNAS", "LUNAS") as debt_status'
        ->leftJoin('buyers', 'debts.buyer_id', '=', 'buyers.id')
        // ->leftJoin('history_pay_debts', 'debts.buyer_id', '=', 'history_pay_debts.buyer_id')
        ->groupBy('buyers.name', 'buyers.address','buyers.id')
        ->orderBy('buyers.id','ASC')
        ->get();
    }

    /**
     * get data detail debt
     */
    public function getDetailDebt(Request $request): mixed
    {
        return $this->model->query()
        ->selectRaw('  nominal as amount,
        created_at as date,
        "debt" as type')
        ->where('buyer_id', $request->buyer_id);
    }
}
