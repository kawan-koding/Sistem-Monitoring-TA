<?php

namespace App\Exports;

use App\Models\ProgramStudi;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class HeadingDosen implements FromCollection, WithHeadings, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect([]);
    }

    public function headings(): array
    {
        return [
            'nip',
            'nidn',
            'nama_dosen',
            'jenis_kelamin',
            'email',
            'telp',
            'alamat',
            'kode_prodi'
        ];
    }

    public function title(): string
    {
        return 'Dosen';
    }
}
