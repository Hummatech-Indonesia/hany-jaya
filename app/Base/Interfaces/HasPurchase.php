<?php

namespace App\Base\Interfaces;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface HasPurchase
{
    /**
     * purchase
     *
     * @return BelongsTo
     */
    public function purchase(): BelongsTo;
}
