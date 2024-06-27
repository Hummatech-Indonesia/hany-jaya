<?php

namespace App\Contracts\Interfaces\Cashier;

use App\Contracts\Interfaces\Eloquent\CustomPaginationInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;

interface HistoryPayDebtInterface extends StoreInterface, CustomPaginationInterface
{
}
