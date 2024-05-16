<?php

namespace App\Observers;

use App\Models\Purchase;
use Faker\Provider\Uuid;

class PurchaseObserver
{
    /**
     * Handle the Purchase "created" event.
     */
    public function creating(Purchase $purchase): void
    {
        $purchase->id = Uuid::uuid();
    }
}
