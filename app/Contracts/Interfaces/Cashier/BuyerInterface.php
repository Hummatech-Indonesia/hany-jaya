<?php

namespace App\Contracts\Interfaces\Cashier;

use App\Contracts\Interfaces\Eloquent\CustomPaginationInterface;
use App\Contracts\Interfaces\Eloquent\GetInterface;
use App\Contracts\Interfaces\Eloquent\GetWhereInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\SumInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;
use Illuminate\Http\Request;

interface BuyerInterface extends StoreInterface, UpdateInterface, GetWhereInterface, ShowInterface, CustomPaginationInterface, SumInterface, GetInterface
{
    /**
     * Handle the Get all data event from models.
     *
     * @return mixed
     */

    public function getBuyer(Request $request): mixed;
    public function getBuyerV2(Request $request): mixed;
    public function getBuyerCustomLimit(Request $request): mixed;
}
