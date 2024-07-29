<?php

namespace App\Contracts\Repositories\Admin;

use App\Contracts\Interfaces\Admin\ProductUnitInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\ProductUnit;
use App\Models\SupplierProduct;

class ProductUnitRepository extends BaseRepository implements ProductUnitInterface
{
    public function __construct(ProductUnit $productUnit)
    {
        $this->model = $productUnit;
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
            ->with('product')
            ->when(count($data) > 0, function ($query) use ($data){
                foreach($data as $index => $value){
                    $query->where($index, $value);   
                }
            })
            ->get();
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
            ->with("product",'unit')
            ->findOrFail($id);
    }
   
}
