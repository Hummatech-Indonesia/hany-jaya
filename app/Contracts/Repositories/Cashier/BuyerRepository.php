<?php

namespace App\Contracts\Repositories\Cashier;

use App\Contracts\Interfaces\Cashier\BuyerInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Buyer;

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
}
