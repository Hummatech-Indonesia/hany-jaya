<?php

namespace App\Contracts\Interfaces\Admin;

use App\Contracts\Interfaces\Eloquent\CustomPaginationInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;

interface PurchaseInterface extends StoreInterface, CustomPaginationInterface
{
}
