<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Interfaces\Admin\CategoryInterface;
use App\Contracts\Interfaces\Admin\ProductInterface;
use App\Contracts\Interfaces\Admin\SupplierInterface;
use App\Contracts\Interfaces\Admin\UnitInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Product;
use App\Services\Admin\ProductService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View as ViewView;

class ProductController extends Controller
{
    private ProductInterface $product;
    private ProductService $productService;
    private CategoryInterface $category;
    private SupplierInterface $supplier;
    private UnitInterface $unit;

    public function __construct(ProductInterface $product, ProductService $productService, CategoryInterface $category, UnitInterface $unit, SupplierInterface $supplier)
    {
        $this->product = $product;
        $this->supplier = $supplier;
        $this->unit = $unit;
        $this->category = $category;
        $this->productService = $productService;
    }

    /**
     * index
     *
     * @return View
     */
    public function index(): View
    {
        $products = $this->product->get();
        return view('dashboard.product.index', compact('products'));
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
        $this->product->store($data);
        return to_route('admin.products.index')->with('success', trans('alert.add_success'));
    }

    /**
     * edit
     *
     * @return View
     */
    public function edit(Product $product): View
    {
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
        $this->product->update($product->id, $data);
        return to_route('admin.products.index')->with('success', trans('alert.update_success'));
    }

    /**
     * delete
     *
     * @param  mixed $product
     * @return RedirectResponse
     */
    public function destroy(Product $product): RedirectResponse
    {
        $this->product->delete($product->id);
        return redirect()->back()->with('success', trans('alert.delete_success'));
    }
}
