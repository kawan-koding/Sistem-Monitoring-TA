<?php

namespace Database\Seeders;

use App\Models\Ruangan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ruangan::insert([
            [
                'kode' => '01',
                'nama_ruangan' => 'Lab. Basis Data',
                'lokasi' => 'Lab. Basis Data',
            ],
            [
                'kode' => '02',
                'nama_ruangan' => 'Lab. Hardware',
                'lokasi' => 'Lab. Hardware',
            ],
        ]);
    }
}
