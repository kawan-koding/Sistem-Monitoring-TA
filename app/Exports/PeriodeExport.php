<?php

namespace App\Exports;

use App\Models\PeriodeTa;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PeriodeExport implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        $periode = PeriodeTa::select('nama','is_active')->get();
        
        $data = $periode->map(function ($item) {
            return [
                'nama' => $item->nama,
                'status' => $item->is_active ? 'Aktif' : 'Tidak Aktif',
            ];
        });
    
        return $data;
    }

    public function headings(): array
    {
        return [
            'Periode Tugas Akhir',
            'Status Periode'
        ];
    }
    public function title(): string
    {
        return 'Periode TA';
    }
}
