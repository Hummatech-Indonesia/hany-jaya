<?php

namespace App\Contracts\Interfaces\Eloquent;

interface SlugInterface
{
    /**
     * Handle restore data instantly from models.
     *
     * @param mixed $slug
     *
     * @return mixed
     */

    public function slug(mixed $slug): mixed;
}
