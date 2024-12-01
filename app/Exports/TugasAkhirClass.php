<?php

namespace App\Exports;

use App\Models\Mahasiswa;
use App\Models\TugasAkhir;
use App\Models\ProgramStudi;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TugasAkhirClass implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles
{
    protected $prodiId;
    protected $kelas;
    protected $periodeId;
    protected $no = 1; 

    public function __construct($prodiId, $kelas, $periodeId)
    {
        $this->prodiId = $prodiId;
        $this->kelas = $kelas;
        $this->periodeId = $periodeId;
    }

    public function beforeSheet(BeforeSheet $event)
    {
        $this->no = 1;
    }

    public function collection()
    {
        $mahasiswa = Mahasiswa::whereProgramStudiId($this->prodiId)->whereKelas($this->kelas)->get();
        $tugasAkhirData = collect();
        foreach ($mahasiswa as $mhs) {
            $tugasAkhir = TugasAkhir::with(['mahasiswa','bimbing_uji'])->whereMahasiswaId($mhs->id)->wherePeriodeTaId($this->periodeId)->whereIn('status', ['acc', 'draft','pengajuan ulang'])->first();
            if ($tugasAkhir) {

                $bimbingUjiData = $tugasAkhir->bimbing_uji->mapWithKeys(function ($item) {
                    if ($item->jenis === 'pengganti') {
                        return [
                            $item->jenis . $item->urut => $item->dosen->name ?? '-',
                        ];
                    }
                    return [
                        $item->jenis . $item->urut => $item->dosen->name ?? '-',
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

    public function headings(): array
    {
        return ['No','NIM','Nama','NO HP','JUDUL/TOPIK','DOSEN PEMBIMBING 1','DOSEN PEMBIMBING 2','DOSEN PENGUJI 1','DOSEN PENGUJI 2',];
    }
    
    public function map($row): array
    {
        $mahasiswa = $row['mahasiswa'] ?? new \stdClass();
        $bimbingUji = $row['bimbingUji'] ?? new \stdClass();
        $tugasAkhir = $row['tugasAkhir'] ?? new \stdClass();

        $pembimbing1 = optional($bimbingUji)['pembimbing1'] ?? '-';
        $pembimbing2 = optional($bimbingUji)['pembimbing2'] ?? '-';
        
        $penguji1 = optional($bimbingUji)['pengganti1'] ?? optional($bimbingUji)['penguji1'] ?? '-';
        $penguji2 = optional($bimbingUji)['pengganti2'] ?? optional($bimbingUji)['penguji2'] ?? '-';

        return [
            $this->no++,
            "'" . optional($mahasiswa)['nim'] ?? '-',
            optional($mahasiswa)['nama_mhs'] ?? '-',
            "'" . optional($mahasiswa)['telp'] ?? '-',
            optional($tugasAkhir)['judul'] ?? '-',
            $pembimbing1,
            $pembimbing2,
            $penguji1,
            $penguji2,
        ];
    }
    
    public function title(): string
    {
        $programStudi = ProgramStudi::find($this->prodiId);
        $title = $programStudi->display . ' ' . $this->kelas;

        return $title;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(25);
        $sheet->getColumnDimension('H')->setWidth(25);
        $sheet->getColumnDimension('I')->setWidth(25);
    
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
