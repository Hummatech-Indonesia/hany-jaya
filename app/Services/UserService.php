<?php

namespace App\Services;

use App\Contracts\Interfaces\UserInterface;
use App\Enums\RoleEnum;
use App\Helpers\UserHelper;
use App\Http\Requests\UserRequest;

class UserService
{
    /**
     * store
     *
     * @param  mixed $request
     * @return array
     */
    public function store(UserRequest $request, UserInterface $user): void
    {
        $data = $request->validated();

        if (UserHelper::getUserRole() == RoleEnum::OWNER->value) {
            $role = RoleEnum::ADMIN->value;
        } else {
            $role = RoleEnum::CASHIER->value;
        }

        $user = $user->store([
            'name' => $data['name'],
            'store_id' => auth()->user()->store->id,
            'outlet_id' => auth()->user()->outlet->id,
            'email' => $data['email'],
            'email_verified_at' => now(),
            'password' => isset($data['password']) ? bcrypt($data['password']) : bcrypt('password'),
        ]);

        $user->assignRole($role);
    }
}
