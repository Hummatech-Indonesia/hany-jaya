<?php

namespace App\Contracts\Interfaces\Admin;

use App\Contracts\Interfaces\Eloquent\CustomPaginationInterface;
use App\Contracts\Interfaces\Eloquent\GetInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\GetWhereInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;
use Illuminate\Http\Request;

interface ProductInterface extends StoreInterface, DeleteInterface, UpdateInterface, ShowInterface, CustomPaginationInterface, GetInterface, GetWhereInterface
{
}
