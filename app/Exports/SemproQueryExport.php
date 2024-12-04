<?php

namespace App\Exports;

use App\Models\TugasAkhir;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SemproQueryExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $periodeId;
    protected $prodiId;
    protected $prodiName;
    protected $periodeName;
    protected $status;
    protected $no = 1;
    
    public function __construct($periodeId, $prodiId, $prodiName, $periodeName, $status)
    {
        $this->periodeId = $periodeId;
        $this->prodiId = $prodiId;
        $this->prodiName = $prodiName;
        $this->periodeName = $periodeName;
        $this->status = $status;
    }

    public function beforeSheet(BeforeSheet $event)
    {
        $this->no = 1;
    }

    public function collection()
    {
        if($this->status == 'sudah_pemberkasan') {
            $ta = TugasAkhir::with(['mahasiswa', 'jadwal_seminar', 'bimbing_uji'])->wherePeriodeTaId($this->periodeId)->whereStatus('acc')->whereNull('status_sidang')->whereStatusPemberkasan('sudah_lengkap')->get();
        } else {
            $ta = TugasAkhir::with(['mahasiswa', 'jadwal_seminar', 'bimbing_uji'])->wherePeriodeTaId($this->periodeId)->whereStatus('acc')->whereHas('jadwal_seminar', function($q) { 
                    $q->whereStatus($this->status);
                })->get();
        }

        $ta = $ta->map(function ($tugasAkhir, $index) {
            $bimbingUjiData = $tugasAkhir->bimbing_uji->mapWithKeys(function ($item) {
                return [$item->jenis . $item->urut => $item->dosen->name ?? '-'];
            });
            $tugasAkhir->bimbing_uji_data = $bimbingUjiData;
            $tugasAkhir->kelas = $tugasAkhir->mahasiswa->kelas;

            return $tugasAkhir;
        });

        $ta = $ta->sortBy(function ($tugasAkhir) {
            return $tugasAkhir->kelas;
        });

        return $ta;
    }

    public function headings(): array
    {
        return [
            'No',
            'Kelas',
            'NIM',
            'Nama',
            'Judul',
            'Pembimbing 1',
            'Pembimbing 2',
            'Penguji 1',
            'Penguji 2',
        ];
    }

    public function map($tugasAkhir): array
    {
        return [
            $this->no++,
            $tugasAkhir->kelas ?? '-',
            "'" . $tugasAkhir->mahasiswa->nim ?? '-',
            $tugasAkhir->mahasiswa->nama_mhs ?? '-',
            $tugasAkhir->judul ?? '-',
            isset($tugasAkhir->bimbing_uji_data['pembimbing1']) ? $tugasAkhir->bimbing_uji_data['pembimbing1'] : '-',
            isset($tugasAkhir->bimbing_uji_data['pembimbing2']) ? $tugasAkhir->bimbing_uji_data['pembimbing2'] : '-',
            isset($tugasAkhir->bimbing_uji_data['penguji1']) ? $tugasAkhir->bimbing_uji_data['penguji1'] : '-',
            isset($tugasAkhir->bimbing_uji_data['penguji2']) ? $tugasAkhir->bimbing_uji_data['penguji2'] : '-',
        ];
    }

    public function title(): string
    {
        return $this->prodiName;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(5);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(40);
        $sheet->getColumnDimension('E')->setWidth(50);
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getColumnDimension('G')->setWidth(30);
        $sheet->getColumnDimension('H')->setWidth(30);
        $sheet->getColumnDimension('I')->setWidth(30);

        return [
            1    => [
                'font' => ['bold' => true, 'color' => ['argb' => '000000']],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['argb' => 'FFFF00'], 
                ],
                'alignment' => [
                    'horizontal' => 'center',
                    'vertical' => 'center',
                ],

            ],

        ];
    }
}
