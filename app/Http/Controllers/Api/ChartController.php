<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Interfaces\Cashier\SellingInterface;
use App\Helpers\BaseResponse;
use App\Http\Controllers\Controller;
use App\Services\ChartService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    private $selling, $chartService;

    public function __construct(
        SellingInterface $selling,
        ChartService $chartService
    )
    {
        $this->selling = $selling;
        $this->chartService = $chartService;
    }

    public function chartPenjualan(Request $request): JsonResponse
    {
        if(!$request->type) return BaseResponse::Error("Field 'type' harus di kirimkan");

        $data = [];
        $queryData = $this->selling->chartData($request);

        $year = $request->date ? Carbon::parse($request->date)->format('Y') : date('Y');
        $month = $request->date ? Carbon::parse($request->date)->format('m') : date('m');

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
}
