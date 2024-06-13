<?php

namespace App\Contracts\Repositories\Cashier;

use App\Contracts\Interfaces\Cashier\BuyerInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Buyer;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class BuyerRepository extends BaseRepository implements BuyerInterface
{
    public function __construct(Buyer $buyer)
    {
        $this->model = $buyer;
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
    public function getWhere(array $data): mixed
    {
        return $this->model->query()
            ->where(['name' => $data['name']])
            ->first();
    }

    /**
     * show
     *
     * @param  mixed $id
     * @return mixed
     */
    public function show(mixed $id): mixed
    {
        return $this->model->query()
            ->findOrFail($id);
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
            ->where('debt', '!=', 0)
            ->fastPaginate($pagination);
    }
}
