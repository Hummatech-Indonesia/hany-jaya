<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Admin\RoleInterface;
use App\Contracts\Interfaces\Eloquent\GetInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\GetWhereInterface;
use App\Contracts\Interfaces\Eloquent\SearchInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;
use App\Contracts\Interfaces\Eloquent\WithRelationInterface;
use Illuminate\Http\Request;

interface UserInterface extends GetInterface, StoreInterface, DeleteInterface, UpdateInterface, ShowInterface, GetWhereInterface, WithRelationInterface
{
    /**
     * Handle the Get all data event from models.
     *
     * @return mixed
     */

    public function getCashier(Request $request): mixed;
    /**
     * Method getAdmin
     *
     * @param Request $request [explicite description]
     *
     * @return mixed
     */
    public function getAdmin(Request $request): mixed;
}
