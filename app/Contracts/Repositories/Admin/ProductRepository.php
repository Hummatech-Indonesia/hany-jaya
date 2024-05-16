<?php

namespace App\Contracts\Repositories\Admin;

use App\Contracts\Interfaces\Admin\ProductInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductRepository extends BaseRepository implements ProductInterface
{
    public function __construct(Product $product)
    {
        $this->model = $product;
    }

    /**
     * get
     *
     * @return mixed
     */
    public function get(): mixed
    {
        return $this->model->query()
            ->where('outlet_id', auth()->user()->outlet->id)
            ->get();
    }

    /**
     * store
     *
     * @param  mixed $data
     * @return mixed
     */
    public function store(array $data): mixed
    {
        $product = $this->model->query()
            ->create($data);

        foreach ($data['supplier_id'] as $supplier_id) {
            $data['supplier_id'] = $supplier_id;

            $product->supplierProducts()->create($data);
        }
        return $product;
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
     * update
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return mixed
     */
    public function update(mixed $id, array $data): mixed
    {
        $product = $this->show($id);
        $product->update($data);

        $product->supplierProducts()->delete();

        foreach ($data['supplier_id'] as $supplier_id) {
            $data['supplier_id'] = $supplier_id;
            $product->supplierProducts()->create($data);
        }

        return $product;
    }

    /**
     * delete
     *
     * @param  mixed $id
     * @return mixed
     */
    public function delete(mixed $id): mixed
    {
        return $this->show($id)->delete($id);
    }
}
