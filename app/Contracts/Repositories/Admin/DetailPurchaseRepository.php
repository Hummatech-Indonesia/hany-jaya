<?php

namespace App\Contracts\Repositories\Admin;

use App\Contracts\Interfaces\Admin\DetailPurchaseInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\DetailPurchase;
use App\Models\Purchase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class DetailPurchaseRepository extends BaseRepository implements DetailPurchaseInterface
{
    public function __construct(DetailPurchase $detailPurchase)
    {
        $this->model = $detailPurchase;
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
