<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Interfaces\Admin\ProductUnitInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ProductUnitResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductUnitController extends Controller
{
    private ProductUnitInterface $productUnit;
    public function __construct(ProductUnitInterface $productUnit)
    {
        $this->productUnit = $productUnit;
    }

    public function index(Product $product): JsonResponse
    {
        $units = $this->productUnit->getWhere(['product_id' => $product->id, "is_delete" => 0]);
        return ResponseHelper::success(ProductUnitResource::collection($units));
    }
}
