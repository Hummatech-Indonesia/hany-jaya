<?php

namespace App\Contracts\Repositories\Cashier;

use App\Contracts\Interfaces\Cashier\BuyerInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Buyer;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class BuyerRepository extends BaseRepository implements BuyerInterface
{
    public function __construct(Buyer $buyer)
    {
        $this->model = $buyer;
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
     * getWhere
     *
     * @param  mixed $data
     * @return mixed
     */
    public function getWhere(array $data): mixed
    {
        return $this->model->query()
            ->when(count($data) > 0, function ($query) use ($data){
                foreach($data as $index => $value){
                    $query->where($index, $value);   
                }
            })
            ->first();
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
            ->where('debt', '!=', 0)
            ->when($request->name, function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->name . '%');
            })
            ->fastPaginate($pagination);
    }

    /**
     * sum
     *
     * @param  mixed $data
     * @return int
     */
    public function sum(?array $data): int
    {
        return $this->model->query()
            ->sum('debt');
    }

    /**
     * get
     *
     * @return mixed
     */
    public function get(): mixed
    {
        return $this->model->query()
            ->withSum('sellings', 'amount_price')
            ->orderByDesc('sellings_sum_amount_price')
            ->take(5)
            ->get();
    }

    /**
     * getBuyer with query search
     *
     * @return mixed
     */
    public function getBuyer(Request $request): mixed
    {
        return $this->model->query()
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->search . '%')->orWhere('address', 'LIKE', '%' . $request->search . '%');
            })->get();
    }

    /**
     * getBuyer with query search
     *
     * @return mixed
     */
    public function getBuyerV2(Request $request): mixed
    {
        return $this->model->query()
            ->with('sellings.detailSellings','payDebts')
            ->when($request->buyer_id, function ($query) use ($request){
                $query->where('id',$request->buyer_id);
            });
    }

    /**
     * getBuyer with query custom
     *
     * @return mixed
     */
    public function getBuyerCustomLimit(Request $request): mixed
    {
        return $this->model->query()
            ->selectRaw('
                *,
                IF(limit_date_debt IS NOT NULL AND DATE(limit_date_debt) > DATE(NOW()), TRUE, FALSE) AS has_exceeded_the_limit
            ')
            ->when($request->buyer_id, function ($query) use ($request){
                $query->where('id',$request->buyer_id);
            });
    }
}
