<?php

namespace App\Contracts\Repositories\Admin;

use App\Contracts\Interfaces\Admin\PurchaseInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseRepository extends BaseRepository implements PurchaseInterface
{
    public function __construct(Purchase $purchase)
    {
        $this->model = $purchase;
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
