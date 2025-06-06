<?php

namespace App\Exports;

use App\Models\Mahasiswa;
use App\Models\TugasAkhir;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class STSemproQueryExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles
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
        $mahasiswa = Mahasiswa::whereProgramStudiId($this->prodiId)->wherePeriodeTaId($this->periodeId) ->orderBy('nim')->get();
        $tugasAkhirData = collect();
        foreach ($mahasiswa as $mhs) {
            $tugasAkhir = TugasAkhir::with(['mahasiswa','bimbing_uji'])->whereMahasiswaId($mhs->id)->wherePeriodeTaId($this->periodeId)->whereIn('status', ['acc', 'draft','pengajuan ulang'])->first();
            if ($tugasAkhir) {
                $bimbingUjiData = $tugasAkhir->bimbing_uji->mapWithKeys(function ($item) {
                    return [
                        $item->jenis . $item->urut => [
                            'name' => $item->dosen->name ?? '-',
                            'nip' => $item->dosen->nip ?? '-',
                        ],
                    ];
                });

                $tugasAkhirData->push([
                    'mahasiswa' => $mhs,
                    'tugasAkhir' => $tugasAkhir,
                    'bimbingUji' => $bimbingUjiData
                ]);
            } else {
                $tugasAkhirData->push([
                    'mahasiswa' => $mhs,
                    'tugasAkhir' => $tugasAkhir,
                    'bimbingUji' => []
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

        $formatDosen = function ($bimbingUji, $key) {
            $name = $bimbingUji[$key]['name'] ?? '-';
            $nip = $bimbingUji[$key]['nip'] ?? '-';
            return "{$name}\nNIP/NIPPPK: {$nip}";
        };

        $pembimbing1 = isset($bimbingUji['pembimbing1']) ? $formatDosen($bimbingUji, 'pembimbing1') : '-';
        $pembimbing2 = isset($bimbingUji['pembimbing2']) ? $formatDosen($bimbingUji, 'pembimbing2') : '-';
        $penguji1 = isset($bimbingUji['penguji1']) ? $formatDosen($bimbingUji, 'penguji1') : '-';
        $penguji2 = isset($bimbingUji['penguji2']) ? $formatDosen($bimbingUji, 'penguji2') : '-';

        return [
            $this->no++,
            "'" .  $mahasiswa['nim'] ?? '-',
            $mahasiswa['nama_mhs'] ?? '-',
            $tugasAkhir->judul ?? '-',
            $pembimbing1,
            $pembimbing2,
            $penguji1,
            $penguji2
        ];
    }

    public function title(): string
    {
        return "Prodi {$this->prodiName}";
    }

    public function headings(): array
    {
        return [
            ['ST PEMBIMBING PENGUJI TUGAS AKHIR '],
            ["PRODI {$this->prodiName}"],
            ["TAHUN {$this->periodeName}"],
            ['No','NIM','Nama','JUDUL/TOPIK','DOSEN PEMBIMBING 1','DOSEN PEMBIMBING 2','DOSEN PENGUJI 1','DOSEN PENGUJI 2',]
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Gaya untuk baris judul
        $sheet->mergeCells('A1:H1');
        $sheet->mergeCells('A2:H2');
        $sheet->mergeCells('A3:H3');

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

        $sheet->getStyle('A4:H4')->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'A9A9A9'],
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

        $sheet->getStyle('E:H')->getAlignment()->setWrapText(true);
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => '000000'],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'argb' => 'FFFF00',
                    ],
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }
}
