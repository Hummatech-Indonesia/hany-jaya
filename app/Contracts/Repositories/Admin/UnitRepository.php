<?php

namespace App\Contracts\Repositories\Admin;

use App\Contracts\Interfaces\Admin\UnitInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Category;
use App\Models\Unit;

class UnitRepository extends BaseRepository implements UnitInterface
{
    public function __construct(Unit $unit)
    {
        $this->model = $unit;
    }

    /**
     * get
     *
     * @return mixed
     */
    public function get(): mixed
    {
        return $this->model->query()
            ->get();
    }
}
