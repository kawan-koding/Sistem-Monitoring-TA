<?php

namespace Database\Seeders;

use App\Models\KategoriNilai;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KategoriNilaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KategoriNilai::insert([
            [
                'nama' => 'Penguasaan Materi',
            ],
            [
                'nama' => 'Tinjauan Pustaka',
            ],
            [
                'nama' => 'Ketepatan Menjawab',
            ],
            [
                'nama' => 'Kedalaman Materi',
            ],
            [
                'nama' => 'Etika',
            ],
            [
                'nama' => 'Kedisiplin',
            ],
        ]);
    }
}
