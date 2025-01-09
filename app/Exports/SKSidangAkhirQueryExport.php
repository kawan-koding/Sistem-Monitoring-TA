<?php

namespace App\Exports;

use App\Models\Mahasiswa;
use App\Models\TugasAkhir;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SKSidangAkhirQueryExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles
{
    protected $periodeId;
    protected $prodiId;
    protected $prodiName;
    protected $periodeName;
    protected $no = 1;

    public function __construct($periodeId, $prodiId, $prodiName, $periodeName)
    {
        $this->periodeId = $periodeId;
        $this->prodiId = $prodiId;
        $this->prodiName = $prodiName;
        $this->periodeName = $periodeName;
    }
    
    public function beforeSheet(BeforeSheet $event)
    {
        $this->no = 1;
    }

    public function collection()
    {
        $mahasiswa = Mahasiswa::whereProgramStudiId($this->prodiId)->wherePeriodeTaId($this->periodeId)->orderBy('nim')->get();
        $tugasAkhirData = collect();
        foreach($mahasiswa as $mhs) {
            $tugasAkhir = TugasAkhir::with(['mahasiswa','bimbing_uji'])->whereMahasiswaId($mhs->id)->wherePeriodeTaId($this->periodeId)->whereIn('status', ['acc', 'draft','pengajuan ulang'])->first();

            if($tugasAkhir) {
                $bimbingUjiData = $tugasAkhir->bimbing_uji->mapWithKeys( function($item) {
                    return [ $item->jenis . $item->urut => $item->dosen->name ?? '-' ];
                });
                $nilai = $tugasAkhir->bimbing_uji->map(function ($bimbingUji) {
                    $nilaiSidang = $bimbingUji->penilaian->filter(function ($nilai) {
                        return $nilai->type == 'Sidang';
                    });
                    $totalNilaiAngka = $nilaiSidang->avg('nilai');
                });

                // $nilai = $tugasAkhir->bimbing_uji->map(function ($bimbingUji) {
                //     $nilaiSeminar = $bimbingUji->penilaian->filter(function ($nilai) {
                //         return $nilai->type == 'Sidang';
                //     });
                //     $totalNilaiAngka = $nilaiSeminar->avg('nilai');
                //     $totalNilaiHuruf = grade($totalNilaiAngka); 
                //     $peran = '';
                //     if ($bimbingUji->jenis == 'pembimbing') {
                //         $peran = 'Pembimbing ' . toRoman($bimbingUji->urut);
                //     } elseif ($bimbingUji->jenis == 'penguji') {
                //         $peran = 'Penguji ' . toRoman($bimbingUji->urut);
                //     }
                //     return [
                //         'peran' => $peran,
                //         'dosen' => $bimbingUji->dosen,
                //         'nilai' => number_format($totalNilaiAngka, 2),
                //     ];        
                // })->toArray();
                
                // $weights = [
                //     'Pembimbing I' => 0.30,
                //     'Pembimbing II' => 0.30,
                //     'Penguji I' => 0.20,
                //     'Penguji II' => 0.20,
                // ];

                // $rekap = [];
                // $totalNilai = 0;
                // $totalNilaiTertimbang = 0;

                // foreach ($nilai as $item) {
                //     $peran = $item['peran'];
                //     if (isset($weights[$peran])) {
                //         $weightedValue = $weights[$peran] * $item['nilai'];
                //         $rekap[] = [
                //             'penilai' => $peran,
                //             'nilai' => number_format($item['nilai'], 2),
                //             'persentase' => ($weights[$peran] * 100) . '% X ' . number_format($item['nilai'], 2) . ' = ' . number_format($weightedValue, 2),
                //         ];

                //         $totalNilai += $item['nilai'];
                //         $totalNilaiTertimbang += $weightedValue;
                //     }
                // }
                // $totalNilaiHuruf = grade($totalNilai / count($rekap));
                
                $tugasAkhirData->push([
                    'mahasiswa' => $mhs,
                    'tugasAkhir' => $tugasAkhir,
                    'bimbingUji' => $bimbingUjiData,
                    // 'sidang' => $tugasAkhir->sidang,
                    // 'nilai' => $nilai,
                ]);
            } else {
                $tugasAkhirData->push([
                    'mahasiswa' => $mhs,
                    'tugasAkhir' => $tugasAkhir,
                    'bimbingUji' => [],
                    'sidang' => $tugasAkhir->sidang,
                    'nilai' => [],
                ]);
            }
        }
        return $tugasAkhirData;
    }

    public function map($row): array
    {   
        $mahasiswa = $row['mahasiswa'] ?? new \stdClass();
        $bimbingUji = $row['bimbingUji'] ?? new \stdClass();
        $tugasAkhir = $row['tugasAkhir'] ?? new \stdClass();
        $pembimbing1 = optional($bimbingUji)['pembimbing1'] ?? '-';
        $pembimbing2 = optional($bimbingUji)['pembimbing2'] ?? '-';
        $penguji1 = optional($bimbingUji)['penguji1'] ?? '-';
        $penguji2 = optional($bimbingUji)['penguji2'] ?? '-';

        return [
            $this->no++,
            $mahasiswa['nama_mhs'] ?? '-',
            "'" .  $mahasiswa['nim'] ?? '-',
            $pembimbing1,
            '-',
            $pembimbing2,
            '-',
            $penguji1,
            $penguji2,
            $tugasAkhir->judul ?? '-',
            '-',
            'TANGGAL SIDANG',
            'NILAI HURUF',
            'NILAI ANGKA',
        ];
    }

    public function headings(): array
    {
        return [
            ['SK PEMBIMBING PENGUJI TUGAS AKHIR'],
            ["{$this->prodiName}"],
            ["YUDISIUM {$this->periodeName}"],
            ['No', 'Nama Mahasiswa', 'NIM', 'Pembimbing 1', '','Pembimbing 2','', 'Penguji 1', 'Penguji 2','Judul Tugas Akhir','Yudisium','Tanggal Sidang','Nilai Huruf','Nilai Angka'],
            ['', '', '', 'Nama Dosen', 'Tepat Waktu/Tidak Tepat Waktu', 'Nama Dosen', 'Tepat Waktu/Tidak Tepat Waktu', '','','','','','',''],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Merge cells
        $sheet->mergeCells('A1:J1');
        $sheet->mergeCells('A2:J2');
        $sheet->mergeCells('A3:J3');
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

        // Style for merged cells in header
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

        // Style for table headers
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
                'startColor' => ['argb' => 'FFFF00'], // Yellow color
            ],
        ]);

        // Additional style for K4:N5
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
                'startColor' => ['argb' => 'FFFF00'], // Yellow color
            ],
        ]);

        // Column widths
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
                'color' => ['argb' => 'FF0000'], // Red color
            ],
        ]);
    }


    // public function registerEvents(): array
    // {
    //     return [
    //         AfterSheet::class => function (AfterSheet $event) {
    //             $sheet = $event->sheet->getDelegate();
    //             $sheet->mergeCells('A1:J1');
    //             $sheet->mergeCells('A2:J2');
    //             $sheet->mergeCells('A3:J3');
    //             $sheet->getStyle('A1:A3')->applyFromArray([
    //                 'alignment' => [
    //                     'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    //                     'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    //                 ],
    //                 'font' => [
    //                     'bold' => true,
    //                     'size' => 14,
    //                 ],
    //             ]);
    //             $sheet->mergeCells('A4:A5');
    //             $sheet->mergeCells('B4:B5');
    //             $sheet->mergeCells('C4:C5');
    //             $sheet->mergeCells('D4:E4');
    //             $sheet->mergeCells('F4:G4');
    //             $sheet->mergeCells('H4:H5');
    //             $sheet->mergeCells('I4:I5');
    //             $sheet->mergeCells('J4:J5');
    //             $sheet->mergeCells('K4:K5');
    //             $sheet->mergeCells('L4:L5');
    //             $sheet->mergeCells('M4:M5');
    //             $sheet->mergeCells('N4:N5');
    //             $sheet->getStyle('A4:J5')->applyFromArray([
    //                 'alignment' => [
    //                     'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    //                     'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    //                 ],
    //                 'font' => [
    //                     'bold' => true,
    //                 ],
    //                 'borders' => [
    //                     'allBorders' => [
    //                         'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //                     ],
    //                 ],
    //                 'fill' => [
    //                     'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
    //                     'startColor' => ['argb' => 'FFFF00'], // Warna kuning
    //                 ],
    //             ]);
    //             $sheet->getStyle('K4:N5')->applyFromArray([
    //                 'alignment' => [
    //                     'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    //                     'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    //                 ],
    //                 'font' => [
    //                     'bold' => true,
    //                 ],
    //                 'fill' => [
    //                     'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
    //                     'startColor' => ['argb' => 'FFFF00'], // Warna kuning
    //                 ],
    //             ]);
    //             $sheet->getColumnDimension('A')->setWidth(5);
    //             $sheet->getColumnDimension('B')->setWidth(20);
    //             $sheet->getColumnDimension('C')->setWidth(15);
    //             $sheet->getColumnDimension('D')->setWidth(30);
    //             $sheet->getColumnDimension('E')->setWidth(20);
    //             $sheet->getColumnDimension('F')->setWidth(30);
    //             $sheet->getColumnDimension('G')->setWidth(20);
    //             $sheet->getColumnDimension('H')->setWidth(30);
    //             $sheet->getColumnDimension('I')->setWidth(30);
    //             $sheet->getColumnDimension('J')->setWidth(50);
    //             $sheet->getColumnDimension('K')->setWidth(15);
    //             $sheet->getColumnDimension('L')->setWidth(20);
    //             $sheet->getColumnDimension('M')->setWidth(15);
    //             $sheet->getColumnDimension('N')->setWidth(15);
    //             $sheet->getStyle('K4:K1000')->applyFromArray([
    //                 'font' => [
    //                     'color' => ['argb' => 'FF0000'],
    //                 ],
    //             ]);
                
    //         },
    //     ];
    // }

    public function title(): string
    {
        return "SK SIDANG AKHIR PRODI {$this->prodiName}";
    }

}
