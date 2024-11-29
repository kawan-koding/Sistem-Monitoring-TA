<?php

namespace App\Exports;

use App\Models\Mahasiswa;
use App\Models\TugasAkhir;
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

    public function __construct($prodiId, $kelas, $periodeId)
    {
        $this->prodiId = $prodiId;
        $this->kelas = $kelas;
        $this->periodeId = $periodeId;
    }

    public function collection()
    {
        $mahasiswa = Mahasiswa::where('program_studi_id', $this->prodiId)
            ->where('kelas', $this->kelas)
            ->get();

        $tugasAkhirData = collect();
        foreach ($mahasiswa as $mhs) {
            $tugasAkhir = TugasAkhir::with(['mahasiswa','bimbing_uji'])->where('mahasiswa_id', $mhs->id)
                ->where('periode_ta_id', $this->periodeId)
                ->where('status', 'acc')
                ->first();

            if ($tugasAkhir) {
                $tugasAkhirData->push($tugasAkhir);
            } else {
                $tugasAkhirData->push((object) [
                    'mahasiswa' => $mhs,
                    'judul' => '-',
                    'status' => 'Belum ada',
                ]);
            }
        }

        return $tugasAkhirData;
    }

    public function headings(): array
    {
        return [
            'No',
            'NIM',
            'Nama',
            'NO HP',
            'JUDUL/TOPIK',
            'DOSEN PEMBIMBING 1',
            'DOSEN PEMBIMBING 2',
            'DOSEN PENGUJI 1',
            'DOSEN PENGUJI 2',
        ];
    }
    
    public function map($row): array
    {
        static $no = 1;
        $dosenPembimbing1 = '-';
        $dosenPembimbing2 = '-';
        $penguji1 = '-';
        $penguji2 = '-';
    
        if (is_object($row) && isset($row->mahasiswa)) {
            $judul = '-';
        } else {
            $dosenPembimbing1 = $row->bimbing_uji->where('jenis', 'pembimbing')->where('urut', 1)->first();
            $dosenPembimbing2 = $row->bimbing_uji->where('jenis', 'pembimbing')->where('urut', 2)->first();
            $dosenPenguji1 = $row->bimbing_uji->where('jenis', 'penguji')->where('urut', 1)->first();
            $dosenPenguji2 = $row->bimbing_uji->where('jenis', 'penguji')->where('urut', 2)->first();
    
            if ($dosenPembimbing1 && $dosenPembimbing1->jenis === 'pengganti') {
                $dosenPembimbing1 = $dosenPembimbing1->dosen ?? '-';
            }
            if ($dosenPembimbing2 && $dosenPembimbing2->jenis === 'pengganti') {
                $dosenPembimbing2 = $dosenPembimbing2->dosen ?? '-';
            }
    
            $penguji1 = $dosenPenguji1 ? $dosenPenguji1->dosen->nama ?? '-' : '-';
            $penguji2 = $dosenPenguji2 ? $dosenPenguji2->dosen->nama ?? '-' : '-';
            $judul = $row->judul ?? '-';
        }
        return [
            $no++,
            "'" . $row->mahasiswa->nim ?? '-',
            $row->mahasiswa->nama_mhs ?? '-',
            "'" . $row->mahasiswa->no_hp ?? '-',
            $row->judul ?? '-',
            $dosenPembimbing1 ? $dosenPembimbing1->dosen->nama ?? '-' : '-',
            $dosenPembimbing2 ? $dosenPembimbing2->dosen->nama ?? '-' : '-',
            $penguji1,
            $penguji2,
        ];
    }

    public function title(): string
    {
        return "Kelas " . $this->kelas;
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
                    'color' => ['argb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'argb' => 'FFFF00',
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
