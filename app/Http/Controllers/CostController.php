<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\Admin\CostInterface;
use App\Contracts\Interfaces\Admin\LossCategoryInterface;
use App\Helpers\BaseDatatable;
use App\Helpers\BaseResponse;
use App\Http\Requests\Admin\CostRequest;
use App\Models\Cost;
use App\Services\Admin\CostService;
use Illuminate\Http\Request;

class CostController extends Controller
{
    private LossCategoryInterface $lossCategory;
    private CostInterface $cost;
    private CostService $costService;

    public function __construct(
        LossCategoryInterface $lossCategory,
        CostInterface $cost,
        CostService $costService
    )
    {
        $this->lossCategory = $lossCategory;
        $this->cost = $cost;
        $this->costService = $costService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(CostRequest $request)
    {
        $data = $this->costService->store($request);
        $this->cost->store($data);

        return redirect()->back()->with('success','Berhasil membuat data pengeluaran');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cost $cost)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cost $cost)
    {
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cost $cost)
    {
        $data = $this->costService->update($request, $cost);
        $this->cost->update($cost->id, $data);

        return redirect()->back()->with('success', 'Berhasil memperbaiki data pengeluaran');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cost $cost)
    {
        $this->cost->delete($cost->id);
        return redirect()->back()->with('success', 'Berhasil menghapus data pengeluaran');
    }

    public function tableCost()
    {
        $data = $this->cost->with(['user','lossCategory','edited_user']);
        return BaseDatatable::TableV2($data->toArray());
    }

    public function createCategory(Request $request)
    {
        if(!$request->name) return response()->json([
            'code' => 500,
            'message' => "Field 'name' harus diisi" 
        ])->statusCode(500);
        

        $this->lossCategory->store([
            "name" => $request->name,
            "desc" => $request->desc
        ]);

        $data = $this->lossCategory->firstLastest();
        return BaseResponse::Ok("Berhasil membuat category", $data);
    }

    public function listCategory(Request $request)
    {
        $data = $this->lossCategory->getCategoryAjax($request);
        return BaseResponse::Ok("Berhasil mengambil data category", $data);
    }

    public function sumLabaRugi(Request $request)
    {
        $data = $this->costService->labaRugi($request);
        return BaseResponse::Ok("Berhasil mengambil data",$data);
    }
}
