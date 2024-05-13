<?php

namespace App\Contracts\Interfaces\Eloquent;

interface InsertInterface
{
    /**
     * Handle insert data event to models.
     *
     * @param array $data
     *
     * @return mixed
     */

    public function insert(array $data): mixed;
}