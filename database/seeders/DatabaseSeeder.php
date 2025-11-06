<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            BrandSeeder::class,
            CarTypeSeeder::class,
            FuelTypeSeeder::class,
            TransmissionSeeder::class,
        ]);
    }
}
