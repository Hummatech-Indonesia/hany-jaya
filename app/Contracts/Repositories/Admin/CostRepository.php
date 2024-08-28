<?php

namespace App\Contracts\Repositories\Admin;

use App\Contracts\Interfaces\Admin\CostInterface;
use App\Contracts\Interfaces\Admin\LossCategoryInterface;
use Illuminate\Database\QueryException;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Cost;
use App\Models\LossCategory;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class CostRepository extends BaseRepository implements CostInterface
{
    public function __construct(Cost $cost)
    {
        $this->model = $cost;
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

    public function sumCustom(array $data): mixed
    {
        return $this->model->query()
        ->selectRaw('
            SUM(price) as price,
            loss_categories.name as category
        ')
        ->leftJoin('loss_categories','costs.loss_category_id','=','loss_categories.id')
        ->when($data, function ($query) use ($data){
            try{
                if($data["year"]) $query->whereYear('costs.date',$data["year"]);

                if($data["month"]) $query->whereMonth('costs.date', $data['month']);
            }catch(\Throwable $th){}
        })
        ->groupBy('loss_categories.name')
        ->get();
    }
}
