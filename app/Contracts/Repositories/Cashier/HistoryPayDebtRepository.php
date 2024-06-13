<?php

namespace App\Contracts\Repositories\Cashier;

use App\Contracts\Interfaces\Cashier\DebtInterface;
use App\Contracts\Interfaces\Cashier\HistoryPayDebtInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Buyer;
use App\Models\Debt;
use App\Models\HistoryPayDebt;

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
}
