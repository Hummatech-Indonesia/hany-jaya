<?php

namespace App\Contracts\Interfaces\Eloquent;

interface WithRelationInterface
{
    /**
     * Implement with relation data
     *
     * @param mixed $id
     * @return mixed
     */

    public function with(array $data): mixed;
}
