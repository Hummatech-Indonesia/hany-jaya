<?php

namespace App\Observers;

use App\Models\Selling;
use Faker\Provider\Uuid;

class SellingObserver
{
    /**
     * Handle the Selling "created" event.
     */
    public function creating(Selling $selling): void
    {
        $selling->id = Uuid::uuid();
        $selling->user_id = auth()->user()->id;
    }
}
