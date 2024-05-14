<?php

namespace App\Contracts\Interfaces\Eloquent;

interface ImportExcelInterface
{
    /**
     * Handle import data event to models.
     *
     * @param array $data
     *
     * @return mixed
     */

    public function import(array $data): mixed;
}
