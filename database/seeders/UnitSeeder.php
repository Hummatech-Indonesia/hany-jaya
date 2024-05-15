<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = ['Ikat', 'Karton', 'Kilo Gram'];

        foreach ($units as $unit) {
            Unit::query()->create([
                'name' => $unit,
            ]);
        }
    }
}
