<?php

namespace App\Base\Interfaces;

use Illuminate\Database\Eloquent\Relations\HasMany;

interface HasDetailSellings
{
    /**
     * detailSellings
     *
     * @return HasMany
     */
    public function detailSellings(): HasMany;
}
