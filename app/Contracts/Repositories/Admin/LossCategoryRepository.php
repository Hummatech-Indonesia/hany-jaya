<?php

namespace App\Contracts\Repositories\Admin;

use App\Contracts\Interfaces\Admin\LossCategoryInterface;
use Illuminate\Database\QueryException;
use App\Contracts\Repositories\BaseRepository;
use App\Models\LossCategory;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class LossCategoryRepository extends BaseRepository implements LossCategoryInterface
{
    public function __construct(LossCategory $category)
    {
        $this->model = $category;
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
     * Method getCategoryAjax
     *
     * @return mixed
     */
    public function getCategoryAjax(Request $request): mixed
    {
        return $this->model->query()
        ->when($request->name, function ($query) use ($request) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        })
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
            ->when($request->relations, function ($query) use ($request) {
                $query->with($request->relations);
            })
            ->when($request->name, function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->name . '%');
            })
            ->fastPaginate($pagination);
    }

    /**
     * get data with relation from this model
     * 
     */
    public function with(array $data): mixed
    {
        return $this->model->with($data)->withCount($data)->get();
    }

     /**
     * get first lastest data
     *
     * @return mixed
     */
    public function firstLastest(): mixed
    {
        return $this->model->latest()->first();
    }
}
