<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\Admin\RoleInterface;
use App\Models\Role;

class RoleRepository extends BaseRepository implements RoleInterface
{
    public function __construct(Role $role)
    {
        $this->model = $role;
    }

    /**
     * getRoles
     *
     * @return mixed
     */
    public function getRoles(): mixed
    {
        return $this->model->query()
            ->get();
    }
}
