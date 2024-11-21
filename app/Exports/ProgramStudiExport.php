<?php

namespace App\Exports;

use App\Models\ProgramStudi;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProgramStudiExport implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        return ProgramStudi::select('kode', 'nama')->get();

    }

    public function headings(): array
    {
        return [
            'Kode Program Studi',
            'Nama Program Studi'
        ];
    }
    public function title(): string
    {
        return 'Program Studi';
    }
}
