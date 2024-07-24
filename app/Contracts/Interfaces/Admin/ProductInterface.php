<?php

namespace App\Contracts\Interfaces\Admin;

use App\Contracts\Interfaces\Eloquent\ActiveDataInterface;
use App\Contracts\Interfaces\Eloquent\CountInterface;
use App\Contracts\Interfaces\Eloquent\CustomPaginationInterface;
use App\Contracts\Interfaces\Eloquent\GetInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\FirstLastestInterface;
use App\Contracts\Interfaces\Eloquent\GetWhereInterface;
use App\Contracts\Interfaces\Eloquent\SoftDeleteInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;
use App\Contracts\Interfaces\Eloquent\WithRelationInterface;
use Illuminate\Http\Request;

interface ProductInterface extends StoreInterface, DeleteInterface, UpdateInterface, ShowInterface, CustomPaginationInterface, GetInterface, GetWhereInterface, CountInterface, WithRelationInterface, FirstLastestInterface,
SoftDeleteInterface, ActiveDataInterface
{
    /**
     * Handle the find data elequest event from models.
     *
     * @return mixed
     */

     public function withElequent(array $data): mixed;
}
