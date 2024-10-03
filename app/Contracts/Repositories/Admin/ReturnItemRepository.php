<?php

namespace App\Contracts\Repositories\Admin;

use App\Contracts\Interfaces\Admin\ReturnItemInterface;
use Illuminate\Database\QueryException;
use App\Contracts\Repositories\BaseRepository;
use App\Models\ReturnItem;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ReturnItemRepository extends BaseRepository implements ReturnItemInterface
{
    public function __construct(ReturnItem $item)
    {
        $this->model = $item;
    }

    /**
     * get
     *
     * @return mixed
     */
    public function get(): mixed
    {
        return $this->model->query()->get();

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
     * delete
     *
     * @param  mixed $id
     * @return mixed
     */
    public function delete(mixed $id): mixed
    {
        try {
            $this->show($id)->delete($id);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451)
                return false;
        }

        return true;
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

    public function groupData(): mixed
    {
        return $this->model->query()
        ->selectRaw('')
        ->with('selling.buyer', 'detail.product.unit')
        ->latest()
        ->get();
    }

    public function latestData(): mixed 
    {
        return $this->model->latest()->first();
    }
}
