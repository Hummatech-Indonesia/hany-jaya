<?php

namespace App\Contracts\Interfaces\Cashier;

use App\Contracts\Interfaces\Eloquent\CustomPaginationInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\WithRelationInterface;

interface HistoryPayDebtInterface extends StoreInterface, CustomPaginationInterface, WithRelationInterface
{
}
