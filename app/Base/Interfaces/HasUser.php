<?php

namespace App\Base\Interfaces;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface HasUser
{
    /**
     * One-to-Many relationship with Category Model
     *
     * @return BelongsTo
     */

    public function user(): BelongsTo;
}