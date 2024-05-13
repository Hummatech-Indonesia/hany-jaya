<?php

namespace App\Contracts\Interfaces\Eloquent;

interface SumInterface
{

  /**
     * Handle sum all data event from models.
     *
     * @param array|null $data
     *
     * @return int
     */

    public function sum(?array $data): int;
}
