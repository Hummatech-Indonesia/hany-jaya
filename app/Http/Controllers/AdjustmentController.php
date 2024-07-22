<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\Admin\AdjustmentHistoryInterface;
use App\Contracts\Interfaces\Admin\CategoryInterface;
use App\Contracts\Interfaces\Admin\ProductInterface;
use App\Helpers\BaseDatatable;
use App\Http\Requests\Admin\AdjustmentHistoryRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdjustmentController extends Controller
{

    private ProductInterface $product;
    private AdjustmentHistoryInterface $adjustment;

    public function __construct(
        ProductInterface $product, AdjustmentHistoryInterface $adjustment
    )
    {
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
        //
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
    public function adjustmentStock(AdjustmentHistoryRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();
        $data["old_stock"] = $product->quantity;
        
        DB::beginTransaction();
        try{
            $test = $this->product->update($product->id, ["quantity" => ($data['new_stock'] ?? $product->quantity)]);
            $test1 = $this->adjustment->store($data);
            dd($test, $test1);

            DB::commit();
            return to_route('admin.adjustments.index')->with('success', trans('alert.update_success'));
        }catch(\Throwable $th){
            dd($th->getMessage());
            DB::rollBack();
            return to_route('admin.adjustments.index')->with('error', 'Gagal merubah stock dengan kesalahan => '.$th->getMessage());
        }
    }

    /**
     * function list datatable
     */
    public function tableAdjustmentHistory()
    {
        $data = $this->adjustment->with(['product']); 

        return BaseDatatable::TableV2($data->toArray());
    }
}
