<?php

namespace App\Contracts\Interfaces\Cashier;

use App\Contracts\Interfaces\Eloquent\CustomPaginationInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\SumInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;

interface DebtInterface extends CustomPaginationInterface, StoreInterface, UpdateInterface, SumInterface
{

    /**
     * Get summary data from this data
     */
    public function getSumDebt(): mixed;
}
