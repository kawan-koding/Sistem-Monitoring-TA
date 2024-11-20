<?php

namespace App\Exports;

use App\Models\PeriodeTa;
use App\Models\TugasAkhir;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TugasAkhirExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        $periode = PeriodeTa::where('is_active', true)->first();
        $tugasAkhir = TugasAkhir::select(
            DB::raw('(select nama_mhs from mahasiswas where id = tugas_akhirs.mahasiswa_id) as mahasiswa'),
            DB::raw('(select nim from mahasiswas where id = tugas_akhirs.mahasiswa_id) as nim'),
            )->where('periode_ta_id', $periode->id)->where('status','acc')->get();
        return $tugasAkhir;
    }

    public function map($row): array
    {
        return [
            $row->mahasiswa,
            "'" . $row->nim,
        ];
    }

    public function headings(): array
    {
        return [
            'Nama Mahasiswa',
            'NIM',
        ];
    }

    public function title(): string
    {
        return 'Tugas Akhir';
    }
}
