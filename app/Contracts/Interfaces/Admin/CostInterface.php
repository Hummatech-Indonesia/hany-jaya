<?php

namespace App\Contracts\Interfaces\Admin;

use App\Contracts\Interfaces\Eloquent\CustomPaginationInterface;
use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\FirstLastestInterface;
use App\Contracts\Interfaces\Eloquent\GetInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;
use App\Contracts\Interfaces\Eloquent\WithRelationInterface;
use Illuminate\Http\Request;

interface CostInterface extends GetInterface, ShowInterface, StoreInterface, DeleteInterface, UpdateInterface, CustomPaginationInterface, WithRelationInterface, FirstLastestInterface

{
    /**
     * Method getCategoryAjax
     *
     * @param Request $request [explicite description]
     *
     * @return mixed
     */
    public function getCategoryAjax(Request $request):mixed;
}
