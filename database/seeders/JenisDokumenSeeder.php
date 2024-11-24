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
                'tipe_dokumen' => 'pdf',
                'max_ukuran' => 1024
            ],
            [
                'nama' => 'SCAN KHS SEMESTER 1-7',
                'jenis' => 'pra_seminar',
                'tipe_dokumen' => 'pdf',
                'max_ukuran' => 1024
            ],
            [
                'nama' => 'BUKTI HEREGRESTASI SEMESTER AKHIR',
                'jenis' => 'pra_seminar',
                'tipe_dokumen' => 'pdf',
                'max_ukuran' => 1024
            ],
            [
                'nama' => 'FORMULIR KESEDIAAN PEMBIMBING 1',
                'jenis' => 'pendaftaran',
                'tipe_dokumen' => 'pdf',
                'max_ukuran' => 1024
            ],
            [
                'nama' => 'FORMULIR KESEDIAAN PEMBIMBING 2',
                'jenis' => 'seminar',
                'tipe_dokumen' => 'pdf',
                'max_ukuran' => 1024
            ],
            [
                'nama' => 'FORM PERMOHONAN SURAT PENGANTAR PENGAMBILAN DATA /PELAKSANAAN TUGAS AKHIR (JIKA ADA)',
                'jenis' => 'seminar',
                'tipe_dokumen' => 'pdf',
                'max_ukuran' => 1024
            ],
            [
                'nama' => 'LEMBAR PENILAIAN SEMINAR PROPOSAL (Pembimbing 1, 2, Penguji 1,2)',
                'jenis' => 'seminar',
                'tipe_dokumen' => 'pdf',
                'max_ukuran' => 1024
            ],
            [
                'nama' => 'REKAPITULASI NILAI AKHIR SEMINAR PROPOSAL',
                'jenis' => 'seminar',
                'tipe_dokumen' => 'pdf',
                'max_ukuran' => 1024
            ],
            [
                'nama' => 'DAFTAR HADIR PESERTA SEMINAR PROPOSAL',
                'jenis' => 'seminar',
                'tipe_dokumen' => 'pdf',
                'max_ukuran' => 1024
            ],
            [
                'nama' => 'FORMULIR REVISI PENGUJI SEMINAR PROPOSAL 1 dan 2',
                'jenis' => 'seminar',
                'tipe_dokumen' => 'pdf',
                'max_ukuran' => 1024
            ],
            [
                'nama' => 'LEMBAR PENGESAHAN SEMINAR PROPOSAL',
                'jenis' => 'seminar',
                'tipe_dokumen' => 'pdf',
                'max_ukuran' => 1024
            ],
            [
                'nama' => 'BUKTI DUKUNG DARI MITRA',
                'jenis' => 'seminar',
                'tipe_dokumen' => 'pdf',
                'max_ukuran' => 1024
            ],
            [
                'nama' => 'DOKUMEN RINGKASAN',
                'jenis' => 'pendaftaran',
                'tipe_dokumen' => 'pdf',
                'max_ukuran' => 1024
            ],
        ]);
    }
}
