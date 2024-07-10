<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Interfaces\Admin\ProductInterface;
use App\Contracts\Interfaces\Cashier\DebtInterface;
use App\Contracts\Interfaces\Cashier\SellingInterface;
use App\Helpers\BaseResponse;
use App\Http\Controllers\Controller;
use App\Services\ChartService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    private $selling, $chartService, $product, $debt;

    public function __construct(
        SellingInterface $selling,
        ProductInterface $product,
        DebtInterface $debt,
        ChartService $chartService,
    )
    {
        $this->selling = $selling;
        $this->product = $product;
        $this->debt = $debt;
        $this->chartService = $chartService;
    }

    public function chartPenjualan(Request $request): JsonResponse
    {
        if(!$request->type) return BaseResponse::Error("Field 'type' harus di kirimkan");

        $data = [];
        $queryData = $this->selling->chartData($request);

        if($request->year) $year = $request->year;
        else $year = $request->date ? Carbon::parse($request->date)->format('Y') : date('Y');
        
        if($request->month) $month = $request->month;
        else $month = $request->date ? Carbon::parse($request->date)->format('m') : date('m');

        switch($request->type){
            case 'all':
                $data = $this->chartService->chartSellingYear($queryData->toArray());
                break;
            case 'yearly':
                $data = $this->chartService->chartSellingMonth($queryData->toArray());
                break;
            case 'monthly':
                $data = $this->chartService->chartSellingDay($queryData->toArray(), $year, $month);
                break;
            default:
                break;
        }
        
        return BaseResponse::Ok("Berhasil mengambil data",$data);
    }

    public function chartCard(Request $request): JsonResponse
    {
        $selling_count = $this->selling->count(["year" => $request->year ?? date('Y')]);
        $selling_sum = $this->selling->sum(["year" => $request->year ?? date('Y')]);
        $product_count = $this->product->count(["year" => $request->year ?? date('Y')]);
        $debt_sum = $this->debt->sum(["year" => $request->year ?? date('Y')]);

        $data = [
            "selling_count" => $selling_count,
            "selling_sum" => $selling_sum,
            "product_count" => $product_count,
            "debt_sum" => $debt_sum
        ];

        return BaseResponse::Ok("Berhasil mengambil data",$data);
    }
}
