<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CarType;
use Illuminate\Support\Str;

class CarTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Berlina'],
            ['name' => 'Coupé'],
            ['name' => 'Cabrio'],
            ['name' => 'SUV'],
            ['name' => 'Crossover'],
            ['name' => 'Station Wagon'],
            ['name' => 'Monovolume'],
            ['name' => 'Pick-up'],
            ['name' => 'Fuoristrada'],
            ['name' => 'Roadster'],
            ['name' => 'Van'],
            // ➕ aggiunti tipi moderni e sportivi
            ['name' => 'Sportiva'],
            ['name' => 'Citycar'],
            ['name' => 'Utilitaria'],
        ];


        foreach ($types as $t) {
            CarType::updateOrCreate(
                ['name' => $t['name']],
                ['slug' => Str::slug($t['name'])]
            );
        }
    }
}
