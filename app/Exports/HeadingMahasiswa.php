<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class HeadingMahasiswa implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        return new Collection([
            [
                '3A',                   // kelas
                '123456789',            // nim
                'Test Mahasiswa',       // nama_mahasiswa
                'L/P',                    // jenis_kelamin (L = Laki-laki / P = Perempuan)
                'test@example.com',     // email
                '081234567890',         // telp
                '58302',                // kode_prodi
            ],
        ]);
    }

    public function headings(): array
    {
        return [
            'kelas',
            'nim',
            'nama_mahasiswa',
            'jenis_kelamin',
            'email',
            'telp',
            'kode_prodi',
        ];
    }

    public function title(): string
    {
        return 'Mahasiswa';
    }
}
