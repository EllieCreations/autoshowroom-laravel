<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transmission;
use Illuminate\Support\Str;

class TransmissionSeeder extends Seeder
{
    public function run(): void
    {
        $transmissions = [
            ['name' => 'Manuale'],
            ['name' => 'Automatico'],
            ['name' => 'Semiautomatico'],
            ['name' => 'CVT'],
            // ➕ aggiunti tecnici e speciali
            ['name' => 'Robotizzato'],
            ['name' => 'Doppia frizione (DSG)'],
        ];

        foreach ($transmissions as $t) {
            Transmission::updateOrCreate(
                ['name' => $t['name']],
                ['slug' => Str::slug($t['name'])]
            );
        }
    }
}
