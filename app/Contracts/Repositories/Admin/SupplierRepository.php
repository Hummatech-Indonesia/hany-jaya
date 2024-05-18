<?php

namespace App\Contracts\Repositories\Admin;

use App\Contracts\Interfaces\Admin\SupplierInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class SupplierRepository extends BaseRepository implements SupplierInterface
{
    public function __construct(Supplier $supplier)
    {
        $this->model = $supplier;
    }

    /**
     * get
     *
     * @return mixed
     */
    public function get(): mixed
    {
        return $this->model->query()
            ->with('supplierProducts.product')
            ->where('outlet_id', auth()->user()->outlet->id)
            ->get();
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
            ->with('supplierProducts.product')
            ->when($request->name, function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->name . '%');
            })
            ->when($request->product, function ($query) use ($request) {
                $query->whereRelation('supplierProducts.product', 'name', 'LIKE', '%' . $request->product . '%');
            })
            ->where('outlet_id', auth()->user()->outlet->id)
            ->fastPaginate(10);
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
        return $this->show($id)->update($data);
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
