<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sensor;

class GenerateSensorData extends Command
{
    /**
     * Nama perintah Artisan.
     *
     * @var string
     */
    protected $signature = 'sensor:generate';

    /**
     * Deskripsi perintah Artisan.
     *
     * @var string
     */
    protected $description = 'Generate data sensor otomatis setiap 20 detik';

    /**
     * Eksekusi perintah.
     */
    public function handle()
    {
        $this->info('Mulai generate data sensor setiap 20 detik...');

        while (true) {
            Sensor::create([
                'ph' => rand(65, 80) / 10,         // 6.5 - 8.0
                'suhu' => rand(270, 340) / 10,     // 27 - 34 °C
                'kekeruhan' => rand(10, 100),      // NTU
                'tinggi_air' => rand(110, 140),    // cm
            ]);

            $this->info('Data baru disimpan pada: ' . now());

            // Tunggu 20 detik sebelum insert berikutnya
            sleep(20);
        }
    }
}
