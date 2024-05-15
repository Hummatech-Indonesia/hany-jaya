<?php

namespace App\Observers;

use App\Models\Product;
use Faker\Provider\Uuid;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function creating(Product $product): void
    {
        $product->id = Uuid::uuid();
        $product->outlet_id = auth()->user()->outlet->id;
    }
}
