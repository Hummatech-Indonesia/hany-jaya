<?php

namespace App\Base\Interfaces;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

interface HasOnePurchase
{

    /**
     * Method purchase
     *
     * @return BelongsTo
     */
    public function purchase(): BelongsTo;
}
