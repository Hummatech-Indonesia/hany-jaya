<?php

namespace App\Observers;

use App\Models\Store;
use Faker\Provider\Uuid;

class StoreObserver
{
    /**
     * Handle the Store "created" event.
     */
    public function creating(Store $store): void
    {
        $store->id = Uuid::uuid();
    }
}
