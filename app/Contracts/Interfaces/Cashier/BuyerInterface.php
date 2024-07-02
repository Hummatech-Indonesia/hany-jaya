<?php

namespace App\Contracts\Interfaces\Cashier;

use App\Contracts\Interfaces\Eloquent\CustomPaginationInterface;
use App\Contracts\Interfaces\Eloquent\GetInterface;
use App\Contracts\Interfaces\Eloquent\GetWhereInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\SumInterface;
use Illuminate\Http\Request;

interface BuyerInterface extends StoreInterface, GetWhereInterface, ShowInterface, CustomPaginationInterface, SumInterface, GetInterface
{
    /**
     * Handle the Get all data event from models.
     *
     * @return mixed
     */

    public function getBuyer(Request $request): mixed;
}
