<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\Admin\AdjustmentHistoryInterface;
use App\Contracts\Interfaces\Admin\CategoryInterface;
use App\Contracts\Interfaces\Admin\ProductInterface;
use App\Helpers\BaseDatatable;
use App\Helpers\BaseResponse;
use App\Http\Requests\Admin\AdjustmentHistoryRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdjustmentController extends Controller
{

    private ProductInterface $product;
    private AdjustmentHistoryInterface $adjustment;

    public function __construct(
        ProductInterface $product,
        AdjustmentHistoryInterface $adjustment
    ) {
        $this->product = $product;
        $this->adjustment = $adjustment;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->product->get();
        return view('dashboard.adjustment.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.adjustment.adjustment');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * update stock
     *
     * @return Returntype
     */
    public function adjustmentStock(Request $request): JsonResponse
    {
        $data = [
            "user_id" => auth()->user()->id,
            'new_stock' => 0,
            'old_stock' => 0,
            'product_id' => ''
        ];
        $payload = $request->all();

        DB::beginTransaction();
        foreach($payload['products'] as $item){
            try {
                $data['product_id'] = $item['id'];
                $data['new_stock'] = $item['newQuantity'];
                $data['old_stock'] = $item['quantity'];
                $data['note'] = $item['note'] ?? '-';

                $this->product->update($item['id'], [
                    "quantity" => ($data['new_stock'] ?? $item['quantity']),
                    "small_unit_id" => $item['unit_id']
                ]);

                $this->adjustment->store($data);    
            } catch (\Throwable $th) {
                DB::rollBack();
                return BaseResponse::Error('Gagal merubah stock dengan kesalahan => ' . $th->getMessage());
            }
        }

        DB::commit();
        return BaseResponse::Ok('Berhasil menyesuaikan data',null);
    }

    /**
     * function list datatable
     */
    public function tableAdjustmentHistory()
    {
        $data = $this->adjustment->with(['product', 'user']);

        return BaseDatatable::TableV2($data->toArray());
    }
}
