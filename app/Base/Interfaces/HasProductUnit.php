<?php

namespace App\Base\Interfaces;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface HasProductUnit
{
    /**
     * HasProductUnit
     *
     * @return BelongsTo
     */
    public function productUnit(): BelongsTo;
}
