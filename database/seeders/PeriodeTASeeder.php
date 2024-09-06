<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PeriodeTa;

class PeriodeTASeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        PeriodeTa::create([
            'nama' => '2022/2023',
            'mulai_daftar' => '2022-12-01',
            'akhir_daftar' => '2022-12-20',
            'mulai_seminar' => '2023-04-01',
            'akhir_seminar' => '2023-04-30',
            'is_active' => 0,
        ]);
        PeriodeTa::create([
            'nama' => '2023/2024',
            'mulai_daftar' => '2022-12-01',
            'akhir_daftar' => '2022-12-20',
            'mulai_seminar' => '2023-04-01',
            'akhir_seminar' => '2023-04-30',
            'is_active' => 1,
        ]);
    }
}
