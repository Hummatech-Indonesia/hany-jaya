<?php

namespace Database\Seeders;

use App\Models\Store;
use Faker\Provider\Uuid;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Store::create([
            'id' => Uuid::uuid(),
            'name' => 'Hany Jaya',
            'logo' => 'storage/logo/logo.jpeg',
            'code_debt' => Str::random(5)
        ]);

        $publicLogoPath = public_path('assets/images/profile/logo.jpeg');
        $storageLogoPath = 'logo/logo.jpeg'; // Path untuk menyimpan logo di storage

        if (file_exists($publicLogoPath)) {
            if (!Storage::disk('public')->exists($storageLogoPath)) {
                Storage::disk('public')->makeDirectory('logo');
                Storage::disk('public')->copy($publicLogoPath, $storageLogoPath);
            }
        } else {
            echo "File logo tidak ditemukan di direktori public/assets/images/profile/logo.jpeg";
        }
    }
}
