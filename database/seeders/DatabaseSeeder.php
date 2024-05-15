<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * @return void
     */

    public function run(): void
    {
        $this->call([
            StoreSeeder::class,
            OutletSeeder::class,
            RoleSeeder::class,
            CategorySeeder::class,
            UnitSeeder::class,
            UserSeeder::class,
        ]);
    }
}
