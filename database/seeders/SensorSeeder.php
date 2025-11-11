<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sensor;

class SensorSeeder extends Seeder
{
    public function run(): void
    {
        Sensor::create([
            'ph' => 7.0,
            'suhu' => 30.0,
            'kekeruhan' => 20.0,
            'tinggi_air' => 120.0,
        ]);
    }
}
