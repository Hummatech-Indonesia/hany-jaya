<?php

namespace App\Contracts\Interfaces\Admin;

use App\Contracts\Interfaces\Eloquent\CustomPaginationInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\SumInterface;
use Illuminate\Http\Request;

interface PurchaseInterface extends StoreInterface, CustomPaginationInterface, SumInterface
{
    /**
     * query with relation
     */
    public function withEloquent(Request $request): mixed;
}
