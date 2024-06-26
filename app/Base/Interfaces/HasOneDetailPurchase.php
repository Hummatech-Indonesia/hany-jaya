<?php

namespace App\Base\Interfaces;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

interface HasOneDetailPurchase
{

    /**
     * Method detailPurchase
     *
     * @return HasOne
     */
    public function detailPurchase(): HasOne;
}
