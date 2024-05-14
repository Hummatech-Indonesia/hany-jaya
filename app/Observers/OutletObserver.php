<?php

namespace App\Observers;

use App\Models\Outlet;
use Faker\Provider\Uuid;

class OutletObserver
{
    /**
     * Handle the Outlet "created" event.
     */
    public function creating(Outlet $outlet): void
    {
        $outlet->id = Uuid::uuid();
    }
}
