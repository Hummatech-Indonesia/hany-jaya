<?php

namespace App\Contracts\Repositories\Admin;

use App\Contracts\Interfaces\Admin\PurchaseInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PurchaseRepository extends BaseRepository implements PurchaseInterface
{
    public function __construct(Purchase $purchase)
    {
        $this->model = $purchase;
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
            ->latest()
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
}
