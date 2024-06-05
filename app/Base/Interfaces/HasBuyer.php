<?php

namespace App\Base\Interfaces;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface HasBuyer
{
    /**
     * buyer
     *
     * @return BelongsTo
     */
    public function buyer(): BelongsTo;
}
