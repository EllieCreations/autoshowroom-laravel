<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            ['name' => 'Abarth'],
            ['name' => 'Alfa Romeo'],
            ['name' => 'Audi'],
            ['name' => 'BMW'],
            ['name' => 'Citroën'],
            ['name' => 'Dacia'],
            ['name' => 'Fiat'],
            ['name' => 'Ford'],
            ['name' => 'Honda'],
            ['name' => 'Hyundai'],
            ['name' => 'Jeep'],
            ['name' => 'Kia'],
            ['name' => 'Lamborghini'],
            ['name' => 'Land Rover'],
            ['name' => 'Lexus'],
            ['name' => 'Maserati'],
            ['name' => 'Mazda'],
            ['name' => 'Mercedes-Benz'],
            ['name' => 'MINI'],
            ['name' => 'Mitsubishi'],
            ['name' => 'Nissan'],
            ['name' => 'Opel'],
            ['name' => 'Peugeot'],
            ['name' => 'Porsche'],
            ['name' => 'Renault'],
            ['name' => 'SEAT'],
            ['name' => 'Skoda'],
            ['name' => 'Suzuki'],
            ['name' => 'Tesla'],
            ['name' => 'Toyota'],
            ['name' => 'Volkswagen'],
            ['name' => 'Volvo'],
            // ➕ aggiunti mancanti di fascia luxury o utility
            ['name' => 'Ferrari'],
            ['name' => 'Jaguar'],
            ['name' => 'Rolls-Royce'],
            ['name' => 'Bentley'],
            ['name' => 'Bugatti'],
        ];


        foreach ($brands as $b) {
            Brand::updateOrCreate(
                ['name' => $b['name']],
                ['slug' => Str::slug($b['name'])]
            );
        }
    }
}
