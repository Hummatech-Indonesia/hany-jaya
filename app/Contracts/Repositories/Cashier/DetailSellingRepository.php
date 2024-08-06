<?php

namespace App\Contracts\Repositories\Cashier;

use App\Contracts\Interfaces\Cashier\DetailSellingInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\DetailPurchase;
use App\Models\DetailSelling;
use Illuminate\Http\Request;

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

    public function detailProductCustom(Request $request): mixed
    {
        return $this->model->query()
        ->selectRaw(
            'sellings.id as data_id,
            buyers.id as name_id,
            CONCAT(buyers.name, " - ", buyers.code) as name,
            buyers.address as address,
            units.name as unit_name,
            detail_sellings.quantity as quantity,
            detail_sellings.product_unit_price as total_per_unit_price,
            detail_sellings.selling_price as total_price,
            detail_sellings.created_at as date,
            "selling" as type'
        )
        ->leftJoin('sellings','detail_sellings.selling_id','=','sellings.id')
        ->leftJoin('buyers','sellings.buyer_id','=','buyers.id')
        ->leftJoin('products','detail_sellings.product_id','=','products.id')
        ->leftJoin('product_units','detail_sellings.product_unit_id','=','product_units.id')
        ->leftJoin('units','product_units.unit_id','=','units.id')
        ->where('detail_sellings.product_id',$request->product_id);
    }
}
