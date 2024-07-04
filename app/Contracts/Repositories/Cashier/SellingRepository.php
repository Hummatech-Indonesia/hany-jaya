<?php

namespace App\Contracts\Repositories\Cashier;

use App\Contracts\Interfaces\Cashier\SellingInterface;
use Illuminate\Database\QueryException;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Selling;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class SellingRepository extends BaseRepository implements SellingInterface
{
    public function __construct(Selling $selling)
    {
        $this->model = $selling;
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
    public function get(): mixed
    {
        return $this->model->query()
            ->where('invoice_number', 'LIKE', '%' . "KLHM" . '%')
            ->orderByDesc('invoice_number')
            ->first();
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
            ->with('detailSellings.product')
            ->with('detailSellings.productUnit.product')
            ->with('detailSellings.productUnit.unit')
            ->latest()
            ->fastPaginate(5);
    }

    /**
     * count
     *
     * @param  mixed $data
     * @return int
     */
    public function count(?array $data): int
    {
        return $this->model->query()
            ->count();
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
            ->sum('amount_price');
    }

    /**
     * getBuyer with query search
     *
     * @return mixed
     */
    public function findTransactionByProductAndUser(Request $request): mixed
    {
        return $this->model->query()
        ->with('detailSellings')
        ->when($request->product_unit_id, function ($query) use ($request) {
            $query->whereHas('detailSellings',function($query2) use ($request){
                $query2->where("product_unit_id", $request->product_unit_id);
            });
        })
        ->where("buyer_id",$request->buyer_id)
        ->latest()->first();
    }
    
    /**
     * query eloquent with relation
     *
     * @return mixed
     */
    public function withEloquent(Request $request): mixed
    {
        return $this->model->query()
        ->with(['detailSellings' => function($query) {
            $query->with(['product','productUnit' => function($query2){
                $query2->with('unit','product');
            }]);    
        },
        'user','buyer'])
        ->when($request->date, function ($query) use ($request) {
            if(strpos($request->date,"s/d")){
                $date = explode("s/d",$request->date);
                $start_date = $date[0] . " 00:00:00";
                $end_date = $date[1] . " 23:59:59";
            } else if (strpos($request->date,"/")){
                $date = explode("/",$request->date);
                $start_date = $date[0] . " 00:00:00";
                $end_date = $date[1] . " 23:59:59";
            }

            if($start_date && $end_date){
                $query->whereBetween('created_at',[$start_date, $end_date]);   
            }else {
                $query->whereDate('created_at', $request->date);
            }
        });
    }
}
