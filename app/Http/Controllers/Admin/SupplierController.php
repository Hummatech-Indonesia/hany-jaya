<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Interfaces\Admin\SupplierInterface;
use App\Helpers\BaseDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SupplierRequest;
use App\Models\Supplier;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    private SupplierInterface $supplier;

    public function __construct(SupplierInterface $supplier)
    {
        $this->supplier = $supplier;
    }

    /**
     * index
     *
     * @return View
     */
    public function index(Request $request): View
    {
        $data = [
            'suppliers' => $this->supplier->customPaginate($request, 3)
        ];
        return view('dashboard.supplier.index', $data);
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return RedirectResponse
     */
    public function store(SupplierRequest $request): RedirectResponse
    {
        $this->supplier->store($request->validated());
        return redirect()->back()->with('success', trans('alert.add_success'));
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $supplier
     * @return RedirectResponse
     */
    public function update(SupplierRequest  $request, Supplier $supplier): RedirectResponse
    {
        $this->supplier->update($supplier->id, $request->validated());
        return redirect()->back()->with('success', trans('alert.update_success'));
    }

    /**
     * delete
     *
     * @param  mixed $supplier
     * @return RedirectResponse
     */
    public function destroy(Supplier $supplier): RedirectResponse
    {
        $this->supplier->delete($supplier->id);
        return redirect()->back()->with('success', trans('alert.delete_success'));
    }

    /**
     * Data table list supplier and product
     * 
     * @return DataTable
     */
    public function tableSupplier(Request $request)
    {
        $supplier = $this->supplier->with(["supplierProducts" => function ($query){ 
            $query->with("product");
        }]);
        return BaseDatatable::TableV2($supplier->toArray());   
    }
}
