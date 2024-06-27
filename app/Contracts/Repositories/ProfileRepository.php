<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\ProfileInterface;
use App\Contracts\Interfaces\UserInterface;
use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileRepository extends BaseRepository implements ProfileInterface
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }
    /**
     * Method update
     *
     * @param mixed $id [explicite description]
     * @param array $data [explicite description]
     *
     * @return mixed
     */
    public function update(mixed $id, array $data): mixed
    {
        return $this->model->query()->findOrFail($id)->update($data);
    }
}
