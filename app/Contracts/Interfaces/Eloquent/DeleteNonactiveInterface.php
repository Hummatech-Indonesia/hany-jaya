<?php

namespace App\Contracts\Interfaces\Eloquent;

interface DeleteNonactiveInterface
{
    /**
     * Implement soft delete method
     *
     * @param mixed $id
     * @return mixed
     */

    public function deleteNonactive(mixed $id, array $data): mixed;
}