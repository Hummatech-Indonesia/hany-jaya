<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\Cashier\BuyerInterface;
use App\Helpers\BaseDatatable;
use App\Helpers\BaseResponse;
use App\Http\Requests\BuyerRequest;
use App\Models\Buyer;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BuyerController extends Controller
{

    private BuyerInterface $buyer;

    public function __construct(BuyerInterface $buyer)
    {
        $this->buyer = $buyer;
    }

    /**
     * listDebt
     *
     * @return View
     */
    public function listDebt(Request $request): View
    {
        $buyers = $this->buyer->customPaginate($request, 5);
        return view('dashboard.debt.users.index', compact('buyers'));
    }

    // get api for buyer
    public function findBuyer(Request $request): JsonResponse
    {
        // checking value buyer name
        $name = $request->name;
        if(strpos($request->name,'-')) {
            try{
                $name = explode('-', $request->name)[0];
            }catch(\Throwable $th){
                $name = $request->name;
            }
        }

        $data = $this->buyer->getWhere([
            "name" => $name,
            "address" => $request->address
        ]);
        return BaseResponse::Ok("Berhasil mengambil data pembeli",$data);
    }

    // get api for buyer by id
    public function findBuyerById(Buyer $buyer): JsonResponse
    {
        return BaseResponse::Ok("Berhasil mengambil data pembeli",$buyer);
    }

    public function checkCodeBuyer(Request $request): JsonResponse
    {
        if(!$request->code) return response()->json([
            "status" => "error",
            "message" => "Code tidak valid",
            "data" => false
        ]);

        $check = $this->buyer->getWhere(["code" => $request->code]);

        if($check){
            if($check->id == $request->buyer_id){
                return response()->json([
                    "status" => "success",
                    "message" => "Code dapat digunakan",
                    "data" => true
                ]);
            } else {
                return response()->json([
                    "status" => "error",
                    "message" => "Code sudah digunakan",
                    "data" => false
                ]);
            }
        } 
        else return response()->json([
            "status" => "success",
            "message" => "Code dapat digunakan",
            "data" => true
        ]);
    }

    public function tableBuyer(Request $request) 
    {
        $data = $this->buyer->getBuyerV2($request);
        return BaseDatatable::Table($data);
    }

    public function index()
    {
        return view('dashboard.buyers.index');
    }

    public function create()
    {

    }

    public function store(BuyerRequest $request)
    {
        $data = $request->validated();

        $this->buyer->store($data);

        return redirect()->route('admin.buyers.index')->with('success',' Berhasil membuat data');
    }

    public function show(Buyer $buyer)
    {

    }

    public function edit(Buyer $buyer)
    {

    }

    public function update(BuyerRequest $request, Buyer $buyer)
    {
        $data = $request->validated();
        $data['telp'] = $data['telp'] ?? $buyer->telp;
        $data['limit_debt'] = $data['limit_debt'] ?? $buyer->limit_debt;
        $data['limit_time_debt'] = $data['limit_time_debt'] ?? $buyer->limit_time_debt;
        $data['limit_date_debt'] = $data['limit_date_debt'] ?? $buyer->limit_date_debt;

        $this->buyer->update($buyer->id, $data);

        return redirect()->route('admin.buyers.index')->with('update',' Berhasil mengupdate data');
    }

    public function delete(Buyer $buyer)
    {

    }
}
