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

    public function detailProductCustom(Request $request): mixed
    {
        return $this->model->query()
        ->selectRaw(
            'purchases.id as data_id,
            suppliers.name as supplier,
            NULL as buyer,
            units.name as unit_name,
            detail_purchases.quantity as quantity,
            detail_purchases.buy_price_per_unit as total_per_unit_price,
            detail_purchases.buy_price as total_price,
            detail_purchases.created_at as date,
            "buying" as type'
        )
        ->leftJoin('purchases','detail_purchases.purchase_id','=','purchases.id')
        ->leftJoin('suppliers','purchases.supplier_id','=','suppliers.id')
        ->leftJoin('products','detail_purchases.product_id','=','products.id')
        ->leftJoin('product_units','detail_purchases.product_unit_id','=','product_units.id')
        ->leftJoin('units','product_units.unit_id','=','units.id')
        ->where('detail_purchases.product_id',$request->product_id);
    }
}
