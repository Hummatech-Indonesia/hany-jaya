<?php

namespace App\Contracts\Interfaces\Cashier;

use App\Contracts\Interfaces\Eloquent\CustomPaginationInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\WithRelationInterface;
use Illuminate\Http\Request;

interface HistoryPayDebtInterface extends StoreInterface, CustomPaginationInterface, WithRelationInterface
{
    public function getDetailDebt(Request $request): mixed;
    
    public function getSumDebt(): mixed;
}
