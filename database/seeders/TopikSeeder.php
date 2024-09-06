<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Topik;

class TopikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Topik::create([
            'nama_topik' => 'Penelitian'
        ]);
        Topik::create([
            'nama_topik' => 'Evaluasi'
        ]);
        Topik::create([
            'nama_topik' => 'Pemanfaatan'
        ]);
    }
}
