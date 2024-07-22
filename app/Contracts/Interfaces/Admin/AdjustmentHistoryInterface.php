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

interface AdjustmentHistoryInterface extends GetInterface, ShowInterface, DeleteInterface, UpdateInterface, CustomPaginationInterface, StoreInterface, FirstLastestInterface, WithRelationInterface
{
}
