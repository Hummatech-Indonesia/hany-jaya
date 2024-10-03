<?php 

namespace App\Contracts\Interfaces\Admin;

use App\Contracts\Interfaces\Eloquent\GetInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;

interface ReturnItemInterface extends StoreInterface
{
    public function groupData(): mixed;
    public function latestData(): mixed;
} 
