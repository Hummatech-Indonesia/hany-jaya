<?php

namespace App\Base\Interfaces;

use Illuminate\Database\Eloquent\Relations\HasMany;

interface HasProducts
{
    /**
     * One-to-Many relationship with Category Model
     *
     * @return HasMany
     */

    public function products(): HasMany;
}
