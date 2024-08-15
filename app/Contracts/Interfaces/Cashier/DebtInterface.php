<?php

namespace App\Contracts\Interfaces\Cashier;

use App\Contracts\Interfaces\Eloquent\CustomPaginationInterface;
use App\Contracts\Interfaces\Eloquent\GetInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\SumInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;
use App\Contracts\Interfaces\Eloquent\WithRelationInterface;
use Illuminate\Http\Request;

interface DebtInterface extends CustomPaginationInterface, StoreInterface, UpdateInterface, SumInterface, GetInterface, WithRelationInterface
{

    /**
     * Get summary data from this data
     */
    public function getSumDebt(): mixed;

    public function getDetailDebt(Request $request): mixed;

    /**
     * getWhere
     *
     * @param  mixed $data
     * @return mixed
     */
    public function getWhereV2(array $data): mixed;

}
