<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class DiskonSeeder extends Seeder
{
    public function run()
    {
        $data = [];
        $nominal_options = [100000, 200000, 300000]; // Pilihan nominal diskon

        for ($i = 0; $i < 10; $i++) {
            $data[] = [
                'tanggal'    => Time::today()->addDays($i)->toDateString(), // Tanggal hari ini + i hari
                'nominal'    => $nominal_options[array_rand($nominal_options)], // Ambil nominal secara acak
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];
        }

        // Using Query Builder
        $this->db->table('diskon')->insertBatch($data);
    }
}