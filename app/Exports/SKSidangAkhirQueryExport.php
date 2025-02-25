<?php

namespace App\Exports;

use Carbon\Carbon;
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
                $pembimbing1 = $tugasAkhir->bimbing_uji()->where('jenis', 'pembimbing')->where('urut', 1)->first();
                $recapPemb1 = isset($pembimbing1->penilaian) ? $pembimbing1->penilaian()->where('type', 'Sidang')->sum('nilai') : 0;
                $countPemb1 = isset($pembimbing1->penilaian) ? $pembimbing1->penilaian()->where('type', 'Sidang')->count() : 0;
                $recapPemb1 = $countPemb1 > 0 ? $recapPemb1 / $countPemb1 : 0;
                $pembimbing2 = $tugasAkhir->bimbing_uji()->where('jenis', 'pembimbing')->where('urut', 2)->first();
                $recapPemb2 = isset($pembimbing2->penilaian) ? $pembimbing2->penilaian()->where('type', 'Sidang')->sum('nilai') : 0;
                $countPemb2 = isset($pembimbing2->penilaian) ? $pembimbing2->penilaian()->where('type', 'Sidang')->count() : 0;
                $recapPemb2 = $countPemb2 > 0 ? $recapPemb2 / $countPemb2 : 0;
                $pengganti1 = $tugasAkhir->bimbing_uji()->where('jenis', 'pengganti')->where('urut', 1)->first();
                $penguji1 = $tugasAkhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', 1)->first();
                $recapPenguji1 = isset($pengganti1->penilaian) ? $pengganti1->penilaian()->where('type', 'Sidang')->sum('nilai') : (isset($penguji1->penilaian) ? $penguji1->penilaian()->where('type', 'Sidang')->sum('nilai') : 0);
                $countPenguji1 = isset($pengganti1->penilaian) ? $pengganti1->penilaian()->where('type', 'Sidang')->count() : (isset($penguji1->penilaian) ? $penguji1->penilaian()->where('type', 'Sidang')->count() : 0);
                $recapPenguji1 = $countPenguji1 > 0 ? $recapPenguji1 / $countPenguji1 : 0;
                $pengganti2 = $tugasAkhir->bimbing_uji()->where('jenis', 'pengganti')->where('urut', 2)->first();
                $penguji2 = $tugasAkhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', 2)->first();
                $recapPenguji2 = isset($pengganti2->penilaian) ? $pengganti2->penilaian()->where('type', 'Sidang')->sum('nilai') : (isset($penguji2->penilaian) ? $penguji2->penilaian()->where('type', 'Sidang')->sum('nilai') : 0);
                $countPenguji2 = isset($pengganti2->penilaian) ? $pengganti2->penilaian()->where('type', 'Sidang')->count() : (isset($penguji2->penilaian) ? $penguji2->penilaian()->where('type', 'Sidang')->count() : 0);
                $recapPenguji2 = $countPenguji2 > 0 ? $recapPenguji2 / $countPenguji2 : 0;
                $nilaiAngka = number_format(($recapPemb1 > 0 ? $recapPemb1 * 0.3 : 0) + ($recapPemb2 > 0 ? $recapPemb2 * 0.3 : 0) + ($recapPenguji1 > 0 ? $recapPenguji1 * 0.2 : 0) + ($recapPenguji2 > 0 ? $recapPenguji2 * 0.2 : 0), 2);
                $nilaiHuruf = grade(($recapPemb1 > 0 ? $recapPemb1 * 0.3 : 0) + ($recapPemb2 > 0 ? $recapPemb2 * 0.3 : 0) + ($recapPenguji1 > 0 ? $recapPenguji1 * 0.2 : 0) + ($recapPenguji2 > 0 ? $recapPenguji2 * 0.2 : 0));

                $getPeng1 = $pengganti1 ? $pengganti1->dosen : ($penguji1 ? $penguji1->dosen : null);
                $getPeng2 = $pengganti2 ? $pengganti2->dosen : ($penguji2 ? $penguji2->dosen : null);
                $tugasAkhirData->push([
                    'mahasiswa' => $mhs,
                    'tugasAkhir' => $tugasAkhir,
                    'pemb_1' => $pembimbing1 ? "{$pembimbing1->dosen->name}\nNIP/NIPPPK : {$pembimbing1->dosen->nip}" : '-',
                    'pemb_2' => $pembimbing2 ? "{$pembimbing2->dosen->name}\nNIP/NIPPPK : {$pembimbing2->dosen->nip}" : '-',
                    'peng_1' => $getPeng1 ? "{$getPeng1->name}\nNIP/NIPPPK : {$getPeng1->nip}" : '-',
                    'peng_2' => $getPeng2 ? "{$getPeng2->name}\nNIP/NIPPPK : {$getPeng2->nip}" : '-',
                    'nilai_huruf' => $nilaiHuruf,
                    'nilai_angka' => $nilaiAngka,
                    'tanggal_sidang' => (isset($tugasAkhir->sidang) && isset($tugasAkhir->sidang->tanggal)) ? Carbon::parse($tugasAkhir->sidang->tanggal)->translatedFormat('l, d F Y') : null,

                ]);

            } else {
                $tugasAkhirData->push([
                    'mahasiswa' => $mhs,
                    'tugasAkhir' => $tugasAkhir,
                    'pemb_1' => '-',
                    'pemb_2' => '-',
                    'peng_1' => '-',
                    'peng_2' => '-',
                    'nilai_huruf' => '-',
                    'nilai_angka' => '-',
                    'tanggal_sidang' => '-'
                ]);
            }
        }
        return $tugasAkhirData;
    }

    public function map($row): array
    {   
        $mahasiswa = $row['mahasiswa'] ?? new \stdClass();
        $tugasAkhir = $row['tugasAkhir'] ?? new \stdClass();
        return [
            $this->no++,
            $mahasiswa['nama_mhs'] ?? '-',
            "'" . ($mahasiswa['nim'] ?? '-'),
            $row['pemb_1'] ?? '-',
            '-',
            $row['pemb_2'] ?? '-',
            '-',
            $row['peng_1'] ?? '-',
            $row['peng_2'] ?? '-',
            $tugasAkhir->judul ?? '-',
            '-',
            $row['tanggal_sidang'] ?? '-',
            $row['nilai_huruf'] ?? '-',
            $row['nilai_angka'] ?? '-',
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
