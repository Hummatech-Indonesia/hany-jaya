<?php

namespace App\Contracts\Interfaces\Admin;

use App\Contracts\Interfaces\Eloquent\CustomPaginationInterface;
use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\GetInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;
use Illuminate\Http\Request;

interface CategoryInterface extends GetInterface, ShowInterface, StoreInterface, DeleteInterface, UpdateInterface, CustomPaginationInterface

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
