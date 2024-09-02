<?php

namespace App\Contracts\Repositories\Admin;

use App\Contracts\Interfaces\Admin\PurchaseInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Purchase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PurchaseRepository extends BaseRepository implements PurchaseInterface
{
    public function __construct(Purchase $purchase)
    {
        $this->model = $purchase;
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
            ->when($request->date, function ($query) use ($request) {
                $query->where('created_at', '>=', Carbon::createFromFormat('m/d/Y', $request->date[0])->startOfDay()->toDateTimeString())
                    ->where('created_at', '<=',  Carbon::createFromFormat('m/d/Y', $request->date[1])->startOfDay()->toDateTimeString());
            })
            ->with('detailPurchase.product')
            ->with('detailPurchase.productUnit.product')
            ->with('detailPurchase.productUnit.unit')
            ->latest()
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
        $data['buy_price'] = $data['total_buy_price'];
        return $this->model->query()
            ->create($data);
    }

    /**
     * query eloquent with relation
     *
     * @return mixed
     */
    public function withEloquent(Request $request): mixed
    {
        return $this->model->query()
        ->with(['listProducts' => function($query) {
            $query->with(['product','productUnit' => function($query2){
                $query2->with('unit','product');
            }]);    
        },
        'user','product','supplier'])
        ->when($request->date, function ($query) use ($request) {
            if(strpos($request->date,"s/d")){
                $date = explode("s/d",$request->date);
                $start_date = Carbon::parse($date[0])->format('Y-m-d') . " 00:00:00";
                $end_date = Carbon::parse($date[1])->format('Y-m-d') . " 23:59:59";
            } else if (strpos($request->date,"/")){
                $date = explode("/",$request->date);
                $start_date = Carbon::parse($date[0])->format('Y-m-d') . " 00:00:00";
                $end_date = Carbon::parse($date[1])->format('Y-m-d') . " 23:59:59";
            }

            if($start_date && $end_date){
                $query->whereBetween('created_at',[$start_date, $end_date]);   
            }else {
                $query->whereDate('created_at', $request->date);
            }
        })
        ->when($request->invoice, function ($query) use ($request){
            $query->where('invoice_number',$request->invpice);
        });
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
            ->when($data, function ($query) use ($data){
                try{
                    if($data["year"]) $query->whereYear('created_at',$data["year"]);

                    if($data["month"]) $query->whereMonth('created_at', $data['month']);
                }catch(\Throwable $th){}
            })
            ->sum('buy_price');
    }
}
