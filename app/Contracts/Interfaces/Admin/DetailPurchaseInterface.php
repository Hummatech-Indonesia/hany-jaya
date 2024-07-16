<?php

namespace App\Contracts\Interfaces\Admin;

use App\Contracts\Interfaces\Eloquent\CustomPaginationInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use Illuminate\Http\Request;

interface DetailPurchaseInterface extends StoreInterface
{
    public function detailProductCustom(Request $request): mixed;
}
