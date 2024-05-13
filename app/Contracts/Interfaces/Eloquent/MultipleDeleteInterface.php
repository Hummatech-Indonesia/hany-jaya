<?php

namespace App\Contracts\Interfaces\Eloquent;

interface MultipleDeleteInterface
{
    /**
     * Handle some data from models.
     *
     * @param array $data
     *
     * @return mixed
     */

    public function multipleDelete(array $data): mixed;
}
