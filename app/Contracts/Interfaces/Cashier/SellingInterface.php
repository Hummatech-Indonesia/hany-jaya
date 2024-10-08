<?php

namespace App\Contracts\Interfaces\Cashier;

use App\Contracts\Interfaces\Eloquent\CountInterface;
use App\Contracts\Interfaces\Eloquent\CustomPaginationInterface;
use App\Contracts\Interfaces\Eloquent\GetInterface;
use App\Contracts\Interfaces\Eloquent\GetWhereInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\SumInterface;
use Illuminate\Http\Request;

interface SellingInterface extends StoreInterface, GetInterface, CustomPaginationInterface, CountInterface, SumInterface, GetWhereInterface
{
    /**
     * Handle the find data event from models.
     *
     * @return mixed
     */

     public function findTransactionByProductAndUser(Request $request): mixed;
    
     /**
     * Handle the eloquent data from models.
     *
     * @return mixed
     */

     public function withEloquent(Request $request): mixed;
     
     /**
     * Handle the chart data from models.
     *
     * @return mixed
     */

     public function chartData(Request $request): mixed;

     public function getInvoice(): mixed;
}
