<?php

namespace App\Exports;

use App\Models\ProgramStudi;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class HeadingMahasiswa implements FromCollection, WithHeadings, WithTitle
{
    
    public function collection()
    {
        return collect([]);
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
            'kode_prodi'
        ];
    }

    public function title(): string
    {
        return 'Mahasiswa';
    }
}
