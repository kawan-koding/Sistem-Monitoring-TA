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
        PeriodeTa::create([
            'nama' => '2024/2025',
            'is_active' => 1,
        ]);
    }
}
