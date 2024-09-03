<?php

namespace App\Contracts\Repositories\Cashier;

use App\Contracts\Interfaces\Cashier\SellingInterface;
use Illuminate\Database\QueryException;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Selling;
use Carbon\Carbon;
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
                // ->selectRaw('SUBSTRING(invoice_number, 5) as invoice')
                ->orderByDesc('invoice_number')
                ->first();
    }

    /**
     * getWhere
     *
     * @param  mixed $data
     * @return mixed
     */
    public function getInvoice(): mixed
    {
        return $this->model->query()
                ->selectRaw('SUBSTRING(invoice_number, 5) as invoice')
                ->orderByDesc('invoice')
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
            ->when($data, function ($query) use ($data){
                try{
                    if($data["year"]) $query->whereYear('created_at',$data["year"]);
                }catch(\Throwable $th){}
            })
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
        $column = "amount_price";
        try{ $column = $data["column"]; } catch(\Throwable $th){  }
        
        return $this->model->query()
            ->when($data, function ($query) use ($data){
                try{
                    if($data["year"]) $query->whereYear('created_at',$data["year"]);

                    if($data["month"]) $query->whereMonth('created_at', $data['month']);
                }catch(\Throwable $th){}
            })
            ->sum($column);
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
        ->when($request->year, function ($query) use ($request){
            $query->whereYear('created_at',$request->year);
        })
        ->when($request->buyer_id, function ($query) use ($request){
            $query->where('buyer_id',$request->buyer_id);
        })
        ->when($request->type, function ($query) use ($request){
            $query->where('status_payment',$request->type);
        })
        ->when($request->selling_id, function ($query) use ($request){
            $query->where('id',$request->selling_id);
        })
        ->when($request->product_id, function ($query) use ($request){
            $query->where('product_id',$request->product_id);
        })
        ->when($request->buyer_code, function ($query) use ($request){
            $query->whereRelation('buyer','code',$request->buyer_code);
        })
        ->when($request->invoice, function ($query) use ($request){
            $invoice = ($request->invoice != "") ? $request->invoice : '-';
            $query->where('invoice_number', $invoice);
        });
    }
    
    /**
     * Get data for chart data
     * 
     * @param Request $request
     * @return data group by 
     */
    public function chartData(Request $request): mixed
    {
        return $this->model
        ->when($request->type, function ($query) use ($request){
            if($request->year) $year = $request->year;
            else $year = $request->date ? Carbon::parse($request->date)->format('Y') : date('Y');
            
            if($request->month) $month = $request->month;
            else $month = $request->date ? Carbon::parse($request->date)->format('m') : date('m');
            
            switch($request->type){
                case 'all':
                    $query->selectRaw(
                        'SUM(amount_price) as total_amount_price, buyer_id, YEAR(created_at) as year'
                    );
                    $query->groupBy('year');
                    break;
                case 'yearly':
                    $query->selectRaw(
                        'SUM(amount_price) as total_amount_price, buyer_id, YEAR(created_at) as year, MONTH(created_at) as month'
                    );
                    $query->whereYear('created_at',$year);
                    $query->groupBy('year');
                    $query->groupBy('month');
                    break;
                case 'monthly':
                    $query->selectRaw(
                        'SUM(amount_price) as total_amount_price, buyer_id, YEAR(created_at) as year, MONTH(created_at) as month, DAY(created_at) as date'
                    );
                    $query->whereYear('created_at',$year);
                    $query->whereMonth('created_at',$month);
                    $query->groupBy('year');
                    $query->groupBy('month');
                    $query->groupBy('date');
                    break;
                default: 
                    $query->selectRaw(
                        'SUM(amount_price) as total_amount_price, buyer_id, YEAR(created_at) as year, MONTH(created_at) as month, DAY(created_at) as date'
                    );
                    $query->groupBy('created_at');
                    break;
            }
        })
        ->groupBy('buyer_id')
        ->get();
    }

    public function getWhere(array $data): mixed
    {
        return $this->model->query()
        ->with('detailSellings')
        ->when(count($data) > 0, function ($query) use ($data){
            foreach($data as $index => $value) $query->where($index, $value);
        });
    }
}

