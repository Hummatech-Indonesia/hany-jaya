<?php

namespace App\Base\Interfaces;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface HasUnit
{
    /**
     * One-to-Many relationship with Category Model
     *
     * @return BelongsTo
     */

    public function unit(): BelongsTo;
}
