<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\UserInterface;
use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Http\Request;

class UserRepository extends BaseRepository implements UserInterface
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * get
     *
     * @return mixed
     */
    public function get(): mixed
    {
        return $this->model->query()
            ->with('roles')
            ->get();
    }


    /**
     * store
     *
     * @param  mixed $data
     * @return mixed
     */
    public function store(array $data): mixed
    {
        return $this->model->query()
            ->create($data);
    }

    /**
     * show
     *
     * @param  mixed $id
     * @return mixed
     */
    public function show(mixed $id): mixed
    {
        return $this->model->query()
            ->findOrFail($id);
    }

    /**
     * update
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return mixed
     */
    public function update(mixed $id, array $data): mixed
    {
        return $this->show($id)->update($data);
    }

    /**
     * delete
     *
     * @param  mixed $id
     * @return mixed
     */
    public function delete(mixed $id): mixed
    {
        return $this->show($id)->delete($id);
    }

    /**
     * getWhere
     *
     * @param  mixed $data
     * @return mixed
     */
    public function getWhere(array $data): mixed
    {
        return $this->model->query()
            ->where('email', $data['email'])
            ->first();
    }

    /**
     * getCashier
     *
     * @return mixed
     */
    public function getCashier(Request $request): mixed
    {
        return $this->model->query()
            ->role(RoleEnum::CASHIER->value)
            ->when($request->name, function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->name . '%');
            })
            ->fastPaginate(10);
    }
    /**
     * Method getAdmin
     *
     * @param Request $request [explicite description]
     *
     * @return mixed
     */
    public function getAdmin(Request $request): mixed
    {
        return $this->model->query()
            ->role(RoleEnum::ADMIN->value)
            ->when($request->name, function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->name . '%');
            })
            ->where('email', '!=', 'admin@gmail.com')
            ->fastPaginate(10);
    }

    /**
     * get data with Relation
     */
    public function with(array $data): mixed
    {
        return $this->model->with($data)->get();
    }
}
