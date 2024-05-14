<?php

namespace Database\Seeders;

use App\Models\Outlet;
use App\Models\Store;
use Faker\Provider\Uuid;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OutletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $store = Store::query()->first();
        Outlet::create([
            'id' => Uuid::uuid(),
            'store_id' => $store->id,
            'address' => 'Jl Krajan Hany Jaya FC',
        ]);
    }
}
