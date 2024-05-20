<?php

namespace App\Base\Interfaces;

use Illuminate\Database\Eloquent\Relations\HasMany;

interface HasProductUnits
{

    /**
     * supplierProducts
     *
     * @return HasMany
     */
    public function productUnits(): HasMany;
}
