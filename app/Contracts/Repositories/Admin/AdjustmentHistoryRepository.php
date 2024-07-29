<?php

namespace App\Contracts\Repositories\Admin;

use App\Contracts\Interfaces\Admin\AdjustmentHistoryInterface;
use App\Contracts\Interfaces\Admin\UnitInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\AdjustmentHistory;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class AdjustmentHistoryRepository extends BaseRepository implements AdjustmentHistoryInterface
{
    public function __construct(AdjustmentHistory $adjusment)
    {
        $this->model = $adjusment;
    }

    /**
     * get
     *
     * @return mixed
     */
    public function get(): mixed
    {
        return $this->model->query()
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
        return $this->show($id)
            ->delete();
    }

    /**
     * Get one latest data from this model
     */
    public function firstLastest(): mixed
    {
        return $this->model->latest()->first();
    }

    public function with(array $data): mixed
    {
        return $this->model->with($data)->get();
    }
}
