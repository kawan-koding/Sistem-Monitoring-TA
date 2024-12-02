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

class STSemproProdiExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles
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
                    return [ $item->jenis . $item->urut => $item->dosen->name ?? '-', ];
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

        // $query = TugasAkhir::where('periode_ta_id', $this->periodeId)->whereIn('status',['acc', 'draft','pengajuan ulang'])->whereHas('mahasiswa', function ($query) {
        //     $query->where('program_studi_id', $this->prodiId);
        // })->with(['mahasiswa' => function ($query) {
        //     $query->orderBy('nim');
        // }])->get()->map(function ($item) {
        //     return [
        //         'nim' => $item->mahasiswa->nim,
        //         'nama' => $item->mahasiswa->nama_mhs,
        //         'judul' => $item->judul,
        //         'pembimbing_1' => $item->bimbing_uji()->where('jenis', 'pembimbing')->where('urut', 1)->first() 
        //             ? $item->bimbing_uji()->where('jenis', 'pembimbing')->where('urut', 1)->first()->dosen->name 
        //             : '-',
        //         'pembimbing_2' => $item->bimbing_uji()->where('jenis', 'pembimbing')->where('urut', 2)->first() 
        //             ? $item->bimbing_uji()->where('jenis', 'pembimbing')->where('urut', 2)->first()->dosen->name 
        //             : '-',
        //         'penguji_1' => $item->bimbing_uji()->where('jenis', 'penguji')->where('urut', 1)->first() 
        //             ? $item->bimbing_uji()->where('jenis', 'penguji')->where('urut', 1)->first()->dosen->name 
        //             : '-',
        //         'penguji_2' => $item->bimbing_uji()->where('jenis', 'penguji')->where('urut', 2)->first() 
        //             ? $item->bimbing_uji()->where('jenis', 'penguji')->where('urut', 2)->first()->dosen->name 
        //             : '-',
        //         // 'penguji_1' => $item->bimbing_uji()->where('jenis', 'penguji')->where('urut', 1)->first() 
        //         //     ? ($item->bimbing_uji()->where('jenis', 'pengganti')->where('urut', 1)->first() 
        //         //         ? $item->bimbing_uji()->where('jenis', 'pengganti')->where('urut', 1)->first()->dosen->name 
        //         //         : $item->bimbing_uji()->where('jenis', 'penguji')->where('urut', 1)->first()->dosen->name)
        //         //     : '-',
        //         // 'penguji_2' => $item->bimbing_uji()->where('jenis', 'penguji')->where('urut', 2)->first() 
        //         //     ? ($item->bimbing_uji()->where('jenis', 'pengganti')->where('urut', 2)->first() 
        //         //         ? $item->bimbing_uji()->where('jenis', 'pengganti')->where('urut', 2)->first()->dosen->name 
        //         //         : $item->bimbing_uji()->where('jenis', 'penguji')->where('urut', 2)->first()->dosen->name)
        //         //     : '-',
        //     ];
        // });
        // return $query;
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
    }
}
