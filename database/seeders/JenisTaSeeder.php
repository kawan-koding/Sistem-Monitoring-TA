<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisTa;

class JenisTaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        JenisTa::create([
            'nama_jenis' => 'Laporan Study Kasus'
        ]);
        JenisTa::create([
            'nama_jenis' => 'Laporan Eksperimental'
        ]);
        JenisTa::create([
            'nama_jenis' => 'Rancang Bangun/Prototype'
        ]);
        JenisTa::create([
            'nama_jenis' => 'Desain'
        ]);
        JenisTa::create([
            'nama_jenis' => 'Kemas Ulang Informasi'
        ]);
    }
}
