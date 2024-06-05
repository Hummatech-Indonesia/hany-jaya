<?php

namespace App\Contracts\Repositories\Cashier;

use App\Contracts\Interfaces\Cashier\SellingInterface;
use Illuminate\Database\QueryException;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Selling;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class SellingRepository extends BaseRepository implements SellingInterface
{
    public function __construct(Selling $selling)
    {
        $this->model = $selling;
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
     * getWhere
     *
     * @param  mixed $data
     * @return mixed
     */
    public function get(): mixed
    {
        return $this->model->query()
            ->where('invoice_number', 'LIKE', '%' . "KLHM" . '%')
            ->first();
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
            ->with('detailSellings.product')
            ->fastPaginate();
    }
}
