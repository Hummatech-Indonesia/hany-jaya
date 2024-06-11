<?php

namespace App\Observers;

use App\Models\Debt;
use Faker\Provider\Uuid;

class DebtObserver
{
    /**
     * Handle the Debt "created" event.
     */
    public function creating(Debt $debt): void
    {
        $debt->id = Uuid::uuid();
    }
}
