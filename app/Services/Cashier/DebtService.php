<?php

namespace App\Services\Cashier;

use App\Contracts\Interfaces\Cashier\SellingInterface;

class DebtService
{
    private SellingInterface $selling;
    public function __construct(SellingInterface $selling)
    {
    }
}
