<?php

namespace App\Contracts\Repositories\Admin;

use App\Contracts\Interfaces\Admin\SupplierProductInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\SupplierProduct;

class SupplierProductRepository extends BaseRepository implements SupplierProductInterface
{
    public function __construct(SupplierProduct $supplierProduct)
    {
        $this->model = $supplierProduct;
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
            ->where('product_id', $data['product_id'])
            ->get();
    }
}
