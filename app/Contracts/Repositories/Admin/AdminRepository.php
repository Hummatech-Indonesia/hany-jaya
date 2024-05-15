<?php

namespace App\Contracts\Repositories\Admin;

use App\Contracts\Interfaces\Admin\SupplierInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Supplier;
use Illuminate\Http\Request;

class AdminRepository extends BaseRepository implements SupplierInterface
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
            ->where('oulet_id', auth()->user()->outlet->id)
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

    /**
     * search
     *
     * @param  mixed $request
     * @return mixed
     */
    public function search(Request $request): mixed
    {
        return $this->model->query()

            ->get();
    }
}
