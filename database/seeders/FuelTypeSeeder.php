<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FuelType;
use Illuminate\Support\Str;

class FuelTypeSeeder extends Seeder
{
    public function run(): void
    {
        $fuels = [
            ['name' => 'Benzina'],
            ['name' => 'Diesel'],
            ['name' => 'Ibrido benzina'],
            ['name' => 'Ibrido diesel'],
            ['name' => 'Plug-in Hybrid'],
            ['name' => 'Elettrico'],
            ['name' => 'GPL'],
            ['name' => 'Metano'],
            ['name' => 'Idrogeno'],
            // ➕ aggiunti moderni
            ['name' => 'Mild Hybrid'],
            ['name' => 'FlexFuel (E85)'],
        ];

        foreach ($fuels as $f) {
            FuelType::updateOrCreate(
                ['name' => $f['name']],
                ['slug' => Str::slug($f['name'])]
            );
        }
    }
}
