<?php

namespace Database\Seeders;

use App\Models\ProgramStudi;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProgramStudiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProgramStudi::insert([
            [
                'jurusan_id' => 1,
                'kode' => '0891',
                'nama' => 'S1 Terapan Teknologi Rekayasa Komputer',
            ],
            [
                'jurusan_id' => 1,
                'kode' => '5540',
                'nama' => 'S1 Terapan Teknologi Rekayasa Perangkat Lunak',
            ],
            [
                'jurusan_id' => 1,
                'kode' => '3253',
                'nama' => 'S1 Terapan Bisnis Digital',
            ],

        ]);
    }
}