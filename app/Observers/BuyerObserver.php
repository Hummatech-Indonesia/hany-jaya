<?php

namespace App\Observers;

use App\Models\Buyer;
use Faker\Provider\Uuid;

class BuyerObserver
{
    /**
     * Handle the Buyer "created" event.
     */
    public function creating(Buyer $buyer): void
    {
        $buyer->id = Uuid::uuid();
    }
}
