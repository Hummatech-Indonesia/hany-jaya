<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Interfaces\Admin\CategoryInterface;
use App\Contracts\Interfaces\Admin\DetailPurchaseInterface;
use App\Contracts\Interfaces\Admin\ProductInterface;
use App\Contracts\Interfaces\Admin\SupplierInterface;
use App\Contracts\Interfaces\Admin\UnitInterface;
use App\Contracts\Interfaces\Cashier\DetailSellingInterface;
use App\Helpers\ResponseHelper;
use App\Helpers\BaseDatatable;
use App\Helpers\BaseResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Http\Requests\Cashier\ShowProductRequest;
use App\Models\Product;
use App\Models\ProductUnit;
use App\Services\Admin\ProductService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    private ProductInterface $product;
    private ProductService $productService;
    private CategoryInterface $category;
    private SupplierInterface $supplier;
    private UnitInterface $unit;
    private DetailPurchaseInterface $detailPurchase;
    private DetailSellingInterface $detailSellings;

    public function __construct(
        ProductInterface $product,
        ProductService $productService,
        CategoryInterface $category,
        UnitInterface $unit,
        SupplierInterface $supplier,
        DetailPurchaseInterface $detailPurchase,
        DetailSellingInterface $detailSellings
    ) {
        $this->product = $product;
        $this->supplier = $supplier;
        $this->unit = $unit;
        $this->category = $category;
        $this->detailPurchase = $detailPurchase;
        $this->detailSellings = $detailSellings;
        $this->productService = $productService;
    }

    /**
     * index
     *
     * @return View
     */
    public function index(Request $request): View
    {
        $products = $this->product->customPaginate($request, 8);
        return view('dashboard.product.index', compact('products'));
    }

    public function show(Product $product): View
    {
        return view('dashboard.product.show', compact('product'));
    }

    /**
     * create
     *
     * @return View
     */
    public function create(): View
    {
        $categories = $this->category->get();
        $units = $this->unit->get();
        $suppliers = $this->supplier->get();
        return view('dashboard.product.create', compact('categories', 'units', 'suppliers'));
    }
    /**
     * store
     *
     * @param  mixed $request
     * @return RedirectResponse
     */
    public function store(ProductRequest $request): RedirectResponse
    {
        $data = $this->productService->store($request);
        $product = $this->product->store($data);
        for ($i = 0; $i < count($data['unit_id']); $i++) {
            ProductUnit::query()->create(
                [
                    'product_id' => $product->id,
                    'unit_id' => $data['unit_id'][$i],
                    'quantity_in_small_unit' => $data['quantity_in_small_unit'][$i],
                    'selling_price' => $data['selling_price'][$i],
                ]
            );
        }
        return to_route('admin.products.index')->with('success', trans('alert.add_success'));
    }

    /**
     * edit
     *
     * @return View
     */
    public function edit(Product $product): View
    {
        $product = $product->with(['productUnits' => function ($query) {
            $query->with("unit");
        }])->find($product->id);
        $categories = $this->category->get();
        $units = $this->unit->get();
        $suppliers = $this->supplier->get();
        return view('dashboard.product.edit', compact('categories', 'units', 'suppliers', 'product'));
    }
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $product
     * @return RedirectResponse
     */
    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $data = $this->productService->update($request, $product);
        DB::beginTransaction();
        try{
            $product = $this->product->update($product->id, $data);
            $productUnits = $product->productUnits;
            
            $productUnitUnused = collect($productUnits)->filter(function ($item) use ($data) {
                if(!in_array($item->unit_id, $data['unit_id'])){
                    return $item;
                }
            });

            for ($i = 0; $i < count($data['unit_id']); $i++) {
                $check_product_unit = $productUnits->where('unit_id',$data['unit_id'][$i])->first();
                if(!$check_product_unit){
                    ProductUnit::query()->create(
                        [
                            'product_id' => $product->id,
                            'unit_id' => $data['unit_id'][$i],
                            'quantity_in_small_unit' => $data['quantity_in_small_unit'][$i],
                            'selling_price' => $data['selling_price'][$i],
                            ]
                        );
                } else {
                    $check_product_unit->update([
                        'quantity_in_small_unit' => $data['quantity_in_small_unit'][$i],
                        'selling_price' => $data['selling_price'][$i],
                    ]);
                }
            }

            $productUnitUnused->each(function($item) {
                if($item) $item->update(["is_delete" => 1, "deleted_at" => now()]);
            });

            DB::commit();
            return to_route('admin.products.index')->with('success', trans('alert.update_success'));
        }catch(\Throwable $th){
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * index page of adjustment stock
     * 
     * @return View
     */
    public function adjustmentIndex(): View
    {
        $products = $this->product->get();
        return view('dashboard.adjustment.index', compact('products'));
    }

    /**
     * delete
     *
     * @param  mixed $product
     * @return RedirectResponse
     */
    public function destroy(Product $product): RedirectResponse
    {
        $this->product->softDelete($product->id);
        return redirect()->back()->with('success', trans('alert.delete_success'));
    }

    /**
     * active data
     *
     * @param  mixed $product
     * @return RedirectResponse
     */
    public function active(Product $product): RedirectResponse
    {
        $this->product->activeData($product->id);
        return redirect()->back()->with('success', 'Berhasil mengembalikan data');
    }

    /**
     * showProduct
     *
     * @return JsonResponse
     */
    public function showProduct(ShowProductRequest $request): JsonResponse
    {
        $product = $this->product->getWhere($request->validated());
        return ResponseHelper::success($product);
    }

    /**
     * Data table yajra list product
     *
     * @return JsonResponse
     */
    public function dataTable(): JsonResponse
    {
        $product = $this->product->withElequent(["unit", "category", "supplierProducts", "productUnits.unit", "detailPurchases.purchase.supplier"])->get();
        return BaseDatatable::TableV2($product->toArray());
    }

    /**
     * Data table yajra list product
     *
     * @return JsonResponse
     */
    public function listProduct(): JsonResponse
    {
        $product = $this->product->withElequent(["unit", "category", "supplierProducts", "productUnits.unit"])->get();
        return BaseResponse::Ok("Berhasil mengambil data product", $product);
    }

    public function lastProduct(Request $request): JsonResponse
    {
        $product = $this->product->firstLastest();
        if (strtolower($request?->response ?? "-") == "code") {
            $product = $this->productService->generateLastCode($product?->code);
        }

        return BaseResponse::OK("Berhasil mengambil data product", $product);
    }

    public function dataDetailTable(Request $request, Product $product): JsonResponse
    {
        $request->merge(["product_id" => $product->id]);
        $data1 = $this->detailPurchase->detailProductCustom($request);
        $data2 = $this->detailSellings->detailProductCustom($request);

        if ($request->type == "selling") {
            $data = $data2->orderBy('date', 'DESC')->get();
        } else if ($request->type == "purchase") {
            $data = $data1->orderBy('date', 'DESC')->get();
        } else {
            $data = $data1->union($data2)->orderBy('date', 'DESC')->get();
        }

        return BaseDatatable::TableV2($data->toArray());
    }

    public function checkCodeProduct(Request $request): JsonResponse
    {
        if (!$request->code) return response()->json([
            "status" => "error",
            "message" => "Code tidak valid",
            "data" => false
        ]);

        $check = $this->product->getWhereV2(["code" => $request->code]);

        if ($check) {
            if ($check->id == $request->product_id) {
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
        } else return response()->json([
            "status" => "success",
            "message" => "Code dapat digunakan",
            "data" => true
        ]);
    }
}
