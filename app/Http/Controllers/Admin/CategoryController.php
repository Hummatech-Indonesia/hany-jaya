<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Interfaces\Admin\CategoryInterface;
use App\Helpers\BaseDatatable;
use App\Helpers\BaseResponse;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    private CategoryInterface $category;
    public function __construct(CategoryInterface $category)
    {
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request["relations"] = ["products"];
        $categories = $this->category->customPaginate($request, 10);
    
        return view('dashboard.category.index', ['categories' => $categories]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $this->category->store($request->validated());
        return redirect()->route('admin.products.index',['tab' => 'category'])->with('success', trans('alert.add_success'));
    }

    /**
     * storeAjax
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function storeAjax(CategoryRequest $request): JsonResponse
    {
        $this->category->store($request->validated());
        $data = $this->category->firstLastest();

        return ResponseHelper::success($data, trans('alert.add_success'));
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $category
     * @return void
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $this->category->update($category->id, $request->validated());
        return redirect()->route('admin.products.index',['tab' => 'category'])->with('success', trans('alert.update_success'));
    }


    /**
     * destroy
     *
     * @param  mixed $category
     * @return void
     */
    public function destroy(Category $category)
    {
        $delete = $this->category->delete($category->id);
        if ($delete == false) {
            return redirect()->route('admin.products.index',['tab' => 'category'])->withErrors(trans('alert.delete_restrict'));
        }
        return redirect()->route('admin.products.index',['tab' => 'category'])->with('success', trans('alert.delete_success'));
    }
    public function getCategoryAjax(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->category->getCategoryAjax($request);
            // $data->sellingProduct = $data->products->sum('detail_sellings_count');
            return $data;
        }
    }
    
    /**
     * List data catgory
     * 
     * @return JsonResponse
     */
    public function listCategory(Request $request){
        $data = $this->category->with(["products"]);
        return BaseResponse::Ok("Berhasil mengambil data kategori",$data);
    }

    /**
     * List data catgory
     * 
     * @return JsonResponse
     */
    public function tableCategory(Request $request){
        $data = $this->category->with(["products"]);
        return BaseDatatable::TableV2($data->toArray());
    }
    
}
