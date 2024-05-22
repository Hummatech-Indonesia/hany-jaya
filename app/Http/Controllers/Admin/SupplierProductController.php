<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Interfaces\Admin\SupplierProductInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\SupplierProductResource;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SupplierProductController extends Controller
{
    private SupplierProductInterface $supplierProduct;
    public function __construct(SupplierProductInterface $supplierProduct)
    {
        $this->supplierProduct = $supplierProduct;
    }

    /**
     * index
     *
     * @return JsonResponse
     */
    public function index(Supplier $supplier): JsonResponse
    {
        $supplierProduct = $this->supplierProduct->getWhere(['supplier_id' => $supplier->id]);
        return ResponseHelper::success(SupplierProductResource::collection($supplierProduct));
    }
}
