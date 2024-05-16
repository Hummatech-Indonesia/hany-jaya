<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Interfaces\Admin\ProductInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Product;
use App\Services\Admin\ProductService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private ProductInterface $product;
    private ProductService $productService;

    public function __construct(ProductInterface $product, ProductService $productService)
    {
        $this->product = $product;
        $this->productService = $productService;
    }

    /**
     * index
     *
     * @return View
     */
    public function index(): View
    {
        $this->product->get();
        return view('');
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
        return redirect()->back()->with('success', trans('alert.add_success'));
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
        $data = $this->productService->store($request, $product);
        $this->product->update($product->id, $data);
        return redirect()->back()->with('success', trans('alert.update_success'));
    }

    /**
     * delete
     *
     * @param  mixed $product
     * @return RedirectResponse
     */
    public function delete(Product $product): RedirectResponse
    {
        $this->product->delete($product->id);
        return redirect()->back()->with('success', trans('alert.delete_success'));
    }
}
