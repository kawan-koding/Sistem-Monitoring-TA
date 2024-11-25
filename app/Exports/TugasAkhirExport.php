<?php

namespace App\Exports;

use App\Models\PeriodeTa;
use App\Models\TugasAkhir;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class TugasAkhirExport implements FromCollection, WithHeadings, WithMapping, WithEvents
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
            ['No', 'Nama', 'Pembimbing'],
            ['', '', 'Nama Pembimbing', 'Periode'],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $sheet->mergeCells('A1:A2');
                $sheet->mergeCells('B1:B2');
                $sheet->mergeCells('C1:D1');

                $sheet->getStyle('A1:D2')->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'font' => [
                        'bold' => true,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);

                $sheet->getColumnDimension('A')->setWidth(5);
                $sheet->getColumnDimension('B')->setWidth(20);
                $sheet->getColumnDimension('C')->setWidth(30);
                $sheet->getColumnDimension('D')->setWidth(15);
            },
        ];
    }

    public function title(): string
    {
        return 'Tugas Akhir';
    }
}
