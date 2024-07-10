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
}
