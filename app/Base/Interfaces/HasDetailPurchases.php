<?php

namespace App\Base\Interfaces;

use Illuminate\Database\Eloquent\Relations\HasMany;

interface HasDetailPurchases
{
    /**
     * detailSellings
     *
     * @return HasMany
     */
    public function detailPurchases(): HasMany;
}
