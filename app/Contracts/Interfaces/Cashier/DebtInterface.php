<?php

namespace App\Contracts\Interfaces\Cashier;

use App\Contracts\Interfaces\Eloquent\CustomPaginationInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;

interface DebtInterface extends CustomPaginationInterface, StoreInterface, UpdateInterface
{
}
