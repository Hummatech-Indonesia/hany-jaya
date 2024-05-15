<?php

namespace App\Base\Interfaces;

use Illuminate\Database\Eloquent\Relations\HasMany;

interface HasSupplierProducts
{

    /**
     * supplierProducts
     *
     * @return HasMany
     */
    public function supplierProducts(): HasMany;
}
