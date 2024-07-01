<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Outlet;
use App\Models\Store;
use App\Models\User;
use Faker\Provider\Uuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Assuming you have roles created already
        $roles = Role::all();
        $outlet = Outlet::query()->first();
        $store = Store::query()->first();
        foreach ($roles as $role) {
            // if ($role == RoleEnum::OWNER->value) {
            //     $user = User::create([
            //         'id' => Uuid::uuid(),
            //         'store_id' => $store->id,
            //         'outlet_id' => null,
            //         'name' => $role->name,
            //         'email' => str_replace(' ', '', $role->name) . "@gmail.com",
            //         'password' => bcrypt('password'),
            //         'email_verified_at' => now(),
            //     ]);
            //     $user->assignRole([RoleEnum::OWNER->value]);
            // } elseif ($role == RoleEnum::ADMIN->value) {
            //     $user = User::create([
            //         'id' => Uuid::uuid(),
            //         'store_id' => $store->id,
            //         'outlet_id' => $outlet->id,
            //         'name' => $role->name,
            //         'email' => str_replace(' ', '', $role->name) . "@gmail.com",
            //         'password' => bcrypt('password'),
            //         'email_verified_at' => now(),
            //     ]);
            //     $user->assignRole([RoleEnum::ADMIN->value, RoleEnum::CASHIER->value]);
            // } else {
            //     $user = User::create([
            //         'id' => Uuid::uuid(),
            //         'store_id' => $store->id,
            //         'outlet_id' => $outlet->id,
            //         'name' => $role->name,
            //         'email' => str_replace(' ', '', $role->name) . "@gmail.com",
            //         'password' => bcrypt('password'),
            //         'email_verified_at' => now(),
            //     ]);
            //     $user->assignRole(RoleEnum::CASHIER->value);
            // }
            switch ($role->name) {
                case RoleEnum::ADMIN->value:
                    $user = User::create([
                        'id' => Uuid::uuid(),
                        'store_id' => $store->id,
                        'outlet_id' => $outlet->id,
                        'name' => $role->name,
                        'email' => str_replace(' ', '', $role->name) . "@gmail.com",
                        'password' => bcrypt('password'),
                        'email_verified_at' => now(),
                    ]);
                    $user->assignRole([RoleEnum::ADMIN->value, RoleEnum::CASHIER->value]);
                    break;
                case RoleEnum::CASHIER->value:
                    $user = User::create([
                        'id' => Uuid::uuid(),
                        'store_id' => $store->id,
                        'outlet_id' => $outlet->id,
                        'name' => $role->name,
                        'email' => str_replace(' ', '', $role->name) . "@gmail.com",
                        'password' => bcrypt('password'),
                        'email_verified_at' => now(),
                    ]);
                    $user->assignRole(RoleEnum::CASHIER->value);
                    break;
                case RoleEnum::OWNER->value:
                    $user = User::create([
                        'id' => Uuid::uuid(),
                        'store_id' => $store->id,
                        'outlet_id' => null,
                        'name' => $role->name,
                        'email' => str_replace(' ', '', $role->name) . "@gmail.com",
                        'password' => bcrypt('password'),
                        'email_verified_at' => now(),
                    ]);
                    $user->assignRole(RoleEnum::OWNER->value);
                    break;
            }
        }
    }
}
