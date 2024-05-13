<?php

namespace App\Contracts\Interfaces\Eloquent;

interface WhereInInterface
{
    /**
     * Handle some data from models.
     *
     * @param array $data
     *
     * @return mixed
     */

    public function whereIn(array $data): mixed;
}
