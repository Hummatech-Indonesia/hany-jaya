<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Interfaces\Admin\UnitInterface;
use App\Helpers\BaseDatatable;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\UnitRequest;
use App\Models\Unit;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    private UnitInterface $unit;
    public function __construct(UnitInterface $unit)
    {
        $this->unit = $unit;
    }

    /**
     * index
     *
     * @return View
     */
    public function index(Request $request): View
    {
        $units = $this->unit->customPaginate($request);
        return view('dashboard.unit.index', ['units' => $units]);
    }

    /**
     * get
     *
     * @return JsonResponse
     */
    public function get(): JsonResponse
    {
        $units = $this->unit->get();
        return ResponseHelper::success($units);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(UnitRequest $request)
    {
        $this->unit->store($request->validated());
        return redirect()->back()->with('success', trans('alert.add_success'));
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $unit
     * @return void
     */
    public function update(UnitRequest $request, Unit $unit)
    {
        $this->unit->update($unit->id, $request->validated());
        return redirect()->back()->with('success', trans('alert.update_success'));
    }


    /**
     * destroy
     *
     * @param  mixed $unit
     * @return void
     */
    public function destroy(Unit $unit)
    {
        $delete = $this->unit->delete($unit->id);
        if ($delete == false) {
            return redirect()->back()->withErrors(trans('alert.delete_restrict'));
        }
        return redirect()->back()->with('success', trans('alert.delete_success'));
    }

    /**
     * List datatable
     * 
     */
    public function tableUnit()
    {
        $data = $this->unit->get();
        return BaseDatatable::TableV2($data->toArray());
    }
}
