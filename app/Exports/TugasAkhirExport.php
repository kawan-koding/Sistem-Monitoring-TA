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
        static $no = 1;
        return [
            $no++,
            $row->mahasiswa,
            "'" . $row->nim,
            'Dosen Pembimbing 1',
            'Tepat Waktu',
            'Dosen Pembimbing 2',
            'Tidak Tepat Waktu',
            '-',
            '-',
            '-',
            '-',
            '-',
            '-',
            '-',
        ];
    }

    public function headings(): array
    {
        return [
            ['No', 'Nama Mahasiswa', 'NIM', 'Pembimbing 1', '','Pembimbing 2','', 'Penguji 1', 'Penguji 2','Judul Tugas Akhir','Yudisium','Tanggal Sidang','Nilai Huruf','Nilai Angka'],
            ['', '', '', 'Nama Dosen', 'Tepat Waktu/Tidak Tepat Waktu', 'Nama Dosen', 'Tepat Waktu/Tidak Tepat Waktu', '','','','','','',''],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->mergeCells('A1:A2');
                $sheet->mergeCells('B1:B2');
                $sheet->mergeCells('C1:C2');
                $sheet->mergeCells('D1:E1');
                $sheet->mergeCells('F1:G1');
                $sheet->mergeCells('H1:H2');
                $sheet->mergeCells('I1:I2');
                $sheet->mergeCells('J1:J2');
                $sheet->mergeCells('K1:K2');
                $sheet->mergeCells('L1:L2');
                $sheet->mergeCells('M1:M2');
                $sheet->mergeCells('N1:N2');

                $sheet->getStyle('A1:N2')->applyFromArray([
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
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFFE01'],
                    ],
                ]);

                $sheet->getColumnDimension('A')->setWidth(5);
                $sheet->getColumnDimension('B')->setWidth(20);
                $sheet->getColumnDimension('C')->setWidth(15);
                $sheet->getColumnDimension('D')->setWidth(30);
                $sheet->getColumnDimension('E')->setWidth(20);
                $sheet->getColumnDimension('F')->setWidth(30);
                $sheet->getColumnDimension('G')->setWidth(20);
                $sheet->getColumnDimension('H')->setWidth(30);
                $sheet->getColumnDimension('I')->setWidth(30);
                $sheet->getColumnDimension('J')->setWidth(50);
                $sheet->getColumnDimension('K')->setWidth(15);
                $sheet->getColumnDimension('L')->setWidth(20);
                $sheet->getColumnDimension('M')->setWidth(15);
                $sheet->getColumnDimension('N')->setWidth(15);

                $sheet->getStyle('K1:K1000')->applyFromArray([
                    'font' => [
                        'color' => ['argb' => 'FF0000'],
                    ],
                ]);
            },
        ];
    }


    public function title(): string
    {
        return 'Tugas Akhir';
    }
}
