<?php

namespace App\Contracts\Repositories\Admin;

use App\Contracts\Interfaces\Admin\PurchaseInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Purchase;
use Carbon\Carbon;
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
            ->when($request->date, function ($query) use ($request) {
                $query->where('created_at', '>=', Carbon::createFromFormat('m/d/Y', $request->date[0])->startOfDay()->toDateTimeString())
                    ->where('created_at', '<=',  Carbon::createFromFormat('m/d/Y', $request->date[1])->startOfDay()->toDateTimeString());
            })
            ->with('detailPurchase.product')
            ->with('detailPurchase.productUnit.product')
            ->with('detailPurchase.productUnit.unit')
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
        $data['buy_price'] = $data['total_buy_price'];
        return $this->model->query()
            ->create($data);
    }
}
