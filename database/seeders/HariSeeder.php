<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Hari;

class HariSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Hari::create([
            'nama_hari' => 'Senin'
        ]);
        Hari::create([
            'nama_hari' => 'Selasa'
        ]);
        Hari::create([
            'nama_hari' => 'Rabu'
        ]);
        Hari::create([
            'nama_hari' => 'Kamis'
        ]);
        Hari::create([
            'nama_hari' => 'Jumat'
        ]);
        Hari::create([
            'nama_hari' => 'Sabtu'
        ]);
        Hari::create([
            'nama_hari' => 'Minggu'
        ]);
    }
}
