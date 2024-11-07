<?php

namespace Database\Seeders;

use App\Models\JenisDokumen;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JenisDokumenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JenisDokumen::insert([
            [
                'nama' => 'FORMULIR PEMENUHAN PERSYARATAN TA',
                'jenis' => 'pra_seminar',
            ],
            [
                'nama' => 'SCAN KHS SEMESTER 1-7',
                'jenis' => 'pra_seminar',
            ],
            [
                'nama' => 'BUKTI HEREGRESTASI SEMESTER AKHIR',
                'jenis' => 'pra_seminar',
            ],
            [
                'nama' => 'FORMULIR KESEDIAAN PEMBIMBING 1',
                'jenis' => 'pendaftaran',
            ],
            [
                'nama' => 'FORMULIR KESEDIAAN PEMBIMBING 2',
                'jenis' => 'seminar',
            ],
            [
                'nama' => 'FORM PERMOHONAN SURAT PENGANTAR PENGAMBILAN DATA /PELAKSANAAN TUGAS AKHIR (JIKA ADA)',
                'jenis' => 'seminar',
            ],
            [
                'nama' => 'LEMBAR PENILAIAN SEMINAR PROPOSAL (Pembimbing 1, 2, Penguji 1,2)',
                'jenis' => 'seminar',
            ],
            [
                'nama' => 'REKAPITULASI NILAI AKHIR SEMINAR PROPOSAL',
                'jenis' => 'seminar',
            ],
            [
                'nama' => 'DAFTAR HADIR PESERTA SEMINAR PROPOSAL',
                'jenis' => 'seminar',
            ],
            [
                'nama' => 'FORMULIR REVISI PENGUJI SEMINAR PROPOSAL 1 dan 2',
                'jenis' => 'seminar',
            ],
            [
                'nama' => 'LEMBAR PENGESAHAN SEMINAR PROPOSAL',
                'jenis' => 'seminar',
            ],
            [
                'nama' => 'BUKTI DUKUNG DARI MITRA',
                'jenis' => 'seminar',
            ]
        ]);
    }
}
