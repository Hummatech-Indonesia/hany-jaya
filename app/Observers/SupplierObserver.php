<?php

namespace App\Observers;

use App\Models\Supplier;
use Faker\Provider\Uuid;

class SupplierObserver
{
    /**
     * Handle the Supplier "created" event.
     */
    public function creating(Supplier $supplier): void
    {
        $supplier->id = Uuid::uuid();
        $supplier->outlet_id = auth()->user()->outlet->id;
    }
}
