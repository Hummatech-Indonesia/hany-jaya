<?php

namespace App\Contracts\Interfaces\Eloquent;

interface ReadAllInterface
{
    /**
     * Handle store data event to models.
     *
     * @param array $data
     *
     * @return mixed
     */

    public function readAll(array $data): mixed;
}
