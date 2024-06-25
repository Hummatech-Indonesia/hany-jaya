<?php

namespace App\Base\Interfaces;

use Illuminate\Database\Eloquent\Relations\HasMany;

interface HasSellings
{
    /**
     * sellings
     *
     * @return HasMany
     */
    public function sellings(): HasMany;
}
