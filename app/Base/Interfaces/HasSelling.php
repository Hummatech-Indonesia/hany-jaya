<?php

namespace App\Base\Interfaces;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface HasSelling
{
    /**
     * purchase
     *
     * @return BelongsTo
     */
    public function selling(): BelongsTo;
}
