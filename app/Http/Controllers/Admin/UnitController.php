<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Interfaces\Admin\UnitInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
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
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $units = $this->unit->get();
        return ResponseHelper::success($units);
    }
}
