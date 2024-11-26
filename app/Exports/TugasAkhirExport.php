<?php

namespace App\Exports;

use App\Models\PeriodeTa;
use App\Models\TugasAkhir;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class TugasAkhirExport implements FromCollection, WithHeadings, WithMapping, WithEvents, WithTitle
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
            ['SK PEMBIMBING PENGUJI TUGAS AKHIR'], // Baris judul 1
            ['PRODI D4 TEKNOLOGI REKAYASA PERANGKAT LUNAK'], // Baris judul 2
            ['YUDISIUM JUNI 2024'],
            ['No', 'Nama Mahasiswa', 'NIM', 'Pembimbing 1', '','Pembimbing 2','', 'Penguji 1', 'Penguji 2','Judul Tugas Akhir','Yudisium','Tanggal Sidang','Nilai Huruf','Nilai Angka'],
            ['', '', '', 'Nama Dosen', 'Tepat Waktu/Tidak Tepat Waktu', 'Nama Dosen', 'Tepat Waktu/Tidak Tepat Waktu', '','','','','','',''],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->mergeCells('A1:J1'); // Judul baris 1
                $sheet->mergeCells('A2:J2'); // Judul baris 2
                $sheet->mergeCells('A3:J3');

                $sheet->getStyle('A1:A3')->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'font' => [
                        'bold' => true,
                        'size' => 14,
                    ],
                ]);

                $sheet->mergeCells('A4:A5');
                $sheet->mergeCells('B4:B5');
                $sheet->mergeCells('C4:C5');
                $sheet->mergeCells('D4:E4');
                $sheet->mergeCells('F4:G4');
                $sheet->mergeCells('H4:H5');
                $sheet->mergeCells('I4:I5');
                $sheet->mergeCells('J4:J5');
                $sheet->mergeCells('K4:K5');
                $sheet->mergeCells('L4:L5');
                $sheet->mergeCells('M4:M5');
                $sheet->mergeCells('N4:N5');
    
                $sheet->getStyle('A4:J5')->applyFromArray([
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
                        'startColor' => ['argb' => 'FFFF00'], // Warna kuning
                    ],
                ]);

                $sheet->getStyle('K4:N5')->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'font' => [
                        'bold' => true,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFFF00'], // Warna kuning
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

                $sheet->getStyle('K4:K1000')->applyFromArray([
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
