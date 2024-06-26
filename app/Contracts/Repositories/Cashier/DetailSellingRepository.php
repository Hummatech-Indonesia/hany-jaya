<?php

namespace App\Contracts\Repositories\Cashier;

use App\Contracts\Interfaces\Cashier\DetailSellingInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\DetailPurchase;
use App\Models\DetailSelling;

class DetailSellingRepository extends BaseRepository implements DetailSellingInterface
{
    public function __construct(DetailSelling $detailSelling)
    {
        $this->model = $detailSelling;
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
     * count
     *
     * @param  mixed $data
     * @return int
     */
    public function count(?array $data): int
    {
        return $this->model->query()
            ->count();
    }
}
