<?php

namespace App\Contracts\Repositories\Admin;

use App\Contracts\Interfaces\Admin\ProductInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository extends BaseRepository implements ProductInterface
{
    public function __construct(Product $product)
    {
        $this->model = $product;
    }


    public function customPaginate(Request $request, int $pagination = 10): LengthAwarePaginator
    {
        return $this->model->query()
            ->with('productUnits')
            ->where('outlet_id', auth()->user()->outlet->id)
            ->where('is_delete',0)
            ->when($request->name, function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->name . '%')->orWhere('code', $request->name);
            })
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
        $data['unit_id'] = $data['small_unit_id'];
        $product = $this->model->query()
            ->create($data);

        return $product;
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

    /**
     * update
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return mixed
     */
    public function update(mixed $id, array $data): mixed
    {
        $data['unit_id'] = $data['small_unit_id'];
        $product = $this->show($id);
        $product->update($data);

        $supplier_id = null;
        try{ $supplier_id = $data["supplier_id"]; }catch(\Throwable $th){ }
        
        if($supplier_id){
            // $product->supplierProducts()->delete();
            $supplierProducts = $product->supplierProducts;
            
            $supplierProductUnused = collect($supplierProducts)->filter(function ($item) use ($data) {
                if(!in_array($item->supplier_id, $data['supplier_id'])){
                    return $item;
                }
            });
            
            for ($i = 0; $i < count($data['supplier_id']); $i++) {
                $data['supplier_id'] = $supplier_id;
                $check_product_unit = $supplierProducts->where('supplier_id',$data['supplier_id'][$i])->first();
                if(!$check_product_unit){
                    $product->supplierProducts()->create($data);
                }else {
                    $check_product_unit->update(["supplier_id",$data['supplier_id'][$i]]);
                }
            }

            $supplierProductUnused->each(function($item) {
                if($item) $item->update(["is_delete" => 1, "deleted_at" => now()]);
            });
        }

        return $product;
    }

    /**
     * delete
     *
     * @param  mixed $id
     * @return mixed
     */
    public function delete(mixed $id): mixed
    {
        return $this->show($id)->delete($id);
    }

    /**
     * soft delete
     *
     * @param  mixed $id
     * @return mixed
     */
    public function softDelete(mixed $id): mixed
    {
        return $this->show($id)->update([
            "is_delete" => 1,
            "deleted_at" => now()
        ]);
    }
    
    /**
     * active
     *
     * @param  mixed $id
     * @return mixed
     */
    public function activeData(mixed $id): mixed
    {
        return $this->show($id)->update([
            "is_delete" => 0,
            "deleted_at" => null
        ]);
    }

    /**
     * get
     *
     * @return mixed
     */
    public function get(): mixed
    {
        return $this->model->query()->where('is_delete',0)->get();
    }

    /**
     * getWhere
     *
     * @param  mixed $data
     * @return mixed
     */
    public function getWhere(array $data): mixed
    {
        $delete = false;
        try { $delete = $data["is_delete"]; }catch(\Throwable $th) { }
        
        return $this->model->query()
            ->with('unit')
            ->with(['productUnits' => function ($query) use ($delete) {
                $query->when($delete !== false, function($query2) use ($delete) {
                    $query2->where("is_delete",$delete);
                })
                ->with('unit')
                ->orderBy('quantity_in_small_unit', 'asc');
            }])
            // ->with('productUnits.unit')
            ->where('is_delete',0)
            ->when($data['code'], function ($query) use ($data){
                $query->where('code', $data['code'])->orWhere('name', $data['code']);
            })
            ->first();
    }

    /**
     * getWhere only data
     *
     * @param  mixed $data
     * @return mixed
     */
    public function getWhereV2(array $data): mixed
    {
        return $this->model->query()
            ->with('productUnits')
            ->when(count($data) > 0, function ($query) use ($data){ 
                foreach($data as $item => $value) {
                    $query->where($item, $data[$item]);
                }
            })
            ->first();
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
            ->when($data, function ($query) use ($data) {
                try {
                    if ($data["year"]) $query->whereYear('created_at', $data["year"]);
                } catch (\Throwable $th) {
                }
            })
            ->where('is_delete',0)
            ->count();
    }

    /**
     * with relation get data
     *
     * @param  array $data
     * @return mixed
     */
    public function with(array $data): mixed
    {
        return $this->model->with($data)->where('is_delete',0)->get();
    }

    /**
     * with relation get data
     *
     * @param  array $data
     * @return mixed
     */
    public function withElequent(array $data): mixed
    {
        $payload = [];
        try{
            $payload = $data["payload"];
            unset($data["payload"]);
        }catch(\Throwable $th){}
        $payload = collect($payload)->filter(fn ($item) => $item);

        return $this->model->with($data)
        ->when(count($payload) > 0, function ($query) use ($payload){
            foreach($payload as $index => $value){
                $query->where($index,$value);
            }
        })
        ->whereRelation('productUnits','is_delete',0)->where('is_delete',0);
    }

    /**
     * Get one latest data from this model
     */
    public function firstLastest(): mixed
    {
        return $this->model->latest()->where('is_delete',0)->first();
    }
}
