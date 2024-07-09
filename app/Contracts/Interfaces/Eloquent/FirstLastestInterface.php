<?php

namespace App\Contracts\Interfaces\Eloquent;

interface FirstLastestInterface
{
    /**
     * Handle the Get first last data event from models.
     *
     * @return mixed
     */

    public function firstLastest(): mixed;
}
