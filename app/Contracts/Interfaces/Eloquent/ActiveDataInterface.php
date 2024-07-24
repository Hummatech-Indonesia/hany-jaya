<?php

namespace App\Contracts\Interfaces\Eloquent;

interface ActiveDataInterface
{
    /**
     * Handle active data 
     *
     * @param mixed $id
     *
     * @return mixed
     */

    public function activeData(mixed $id): mixed;

}
