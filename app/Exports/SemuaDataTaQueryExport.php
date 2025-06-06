<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\TugasAkhir;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SemuaDataTaQueryExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
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
        $query = TugasAkhir::with(['mahasiswa', 'jadwal_seminar', 'bimbing_uji','sidang'])->wherePeriodeTaId($this->periodeId)->whereStatus('acc');

        if($this->status == 'sudah_pemberkasan') {
            $query->whereNotNull('status_sidang')->orWhere('status_pemberkasan', 'sudah_lengkap');
        } elseif(in_array($this->status, ['belum_terjadwal','telah_seminar','sudah_pemberkasan','sudah_terjadwal'])) {
            $query->whereHas('jadwal_seminar', function($q) {
                $q->whereStatus($this->status);
            });
        } elseif(in_array($this->status, ['belum_daftar','sudah_sidang','sudah_terjadwal_sidang','sudah_daftar'])) {
            $sts = $this->status === 'sudah_terjadwal_sidang' ? 'sudah_terjadwal' : $this->status;
            dd($sts);
            $query->whereHas('sidang', function($q) use ($sts) {
                $q->whereStatus($sts);
            });
        } elseif($this->status == 'sudah_pemberkasan_sidang') {
            $query->whereNotNull('status_sidang')->whereStatusPemberkasan('sudah_lengkap');
            dd('disini 2');
        }
        $query = $query->get();
        $query = $query->map(function ($tugasAkhir, $index) {
            $bimbingUjiData = $tugasAkhir->bimbing_uji->mapWithKeys(function ($item) {
                return [
                    $item->jenis . $item->urut => [
                        'name' => $item->dosen->name ?? '-',
                        'nip' => $item->dosen->nip ?? '-',
                    ],
                ];
            });
            $tugasAkhir->bimbing_uji_data = $bimbingUjiData;
            $tugasAkhir->kelas = $tugasAkhir->mahasiswa->kelas;
            Carbon::setLocale('id');
            if (in_array($this->status,['belum_terjadwal','telah_seminar','sudah_pemberkasan','sudah_terjadwal'])) {
                $tugasAkhir->tanggal = !is_null($tugasAkhir->jadwal_seminar->tanggal) ? Carbon::parse($tugasAkhir->jadwal_seminar->tanggal)->translatedFormat('l, d F Y') : null;
                $tugasAkhir->jam = !is_null($tugasAkhir->jadwal_seminar->jam_mulai) && !is_null($tugasAkhir->jadwal_seminar->jam_selesai) ? Carbon::parse($tugasAkhir->jadwal_seminar->jam_mulai)->format('H:i') . ' - ' . Carbon::parse($tugasAkhir->jadwal_seminar->jam_selesai)->format('H:i') : null;
                $tugasAkhir->tempat = !is_null($tugasAkhir->jadwal_seminar->ruangan) ? $tugasAkhir->jadwal_seminar->ruangan->nama_ruangan : null;
            } elseif (in_array($this->status,['belum_daftar','sudah_sidang','sudah_terjadwal_sidang','sudah_daftar','sudah_pemberkasan_sidang'])) {
                $tugasAkhir->tanggal = !is_null($tugasAkhir->sidang->tanggal) ? Carbon::parse($tugasAkhir->sidang->tanggal)->translatedFormat('l, d F Y') : null;
                $tugasAkhir->jam = !is_null($tugasAkhir->sidang->jam_mulai) && !is_null($tugasAkhir->sidang->jam_selesai) ? Carbon::parse($tugasAkhir->sidang->jam_mulai)->format('H:i') . ' - ' . Carbon::parse($tugasAkhir->sidang->jam_selesai)->format('H:i') : null;
                $tugasAkhir->tempat = !is_null($tugasAkhir->sidang->ruangan) ? $tugasAkhir->sidang->ruangan->nama_ruangan : null;
            }
            return $tugasAkhir;
        });
        $query = $query->sortBy(function ($tugasAkhir) {
            return $tugasAkhir->kelas;
        });
        return $query;
    }

    public function headings(): array
    {
        return [
            'No',
            'Kelas',
            'NIM',
            'Nama',
            'Judul',
            'Tipe TA',
            'Pembimbing 1',
            'Pembimbing 2',
            'Penguji 1',
            'Penguji 2',
            'Tanggal',
            'Waktu',
            'Tempat',
        ];
    }

    public function map($tugasAkhir): array
    {
        $tipe = $tugasAkhir->tipe === 'I' ? 'Individu' : ($tugasAkhir->tipe === 'K' ? 'Kelompok' : '-');
        $formatDosen = function ($bimbingUji, $key) {
            if (isset($bimbingUji[$key])) {
                $name = $bimbingUji[$key]['name'] ?? '-';
                $nip = $bimbingUji[$key]['nip'] ?? '-';
                return "{$name}\nNIP/NIPPPK: {$nip}";
            }
            return '-';
        };

        return [
            $this->no++,
            $tugasAkhir->kelas ?? '-',
            "'" . ($tugasAkhir->mahasiswa->nim ?? '-'),
            $tugasAkhir->mahasiswa->nama_mhs ?? '-',
            $tugasAkhir->judul ?? '-',
            $tipe,
            $formatDosen($tugasAkhir->bimbing_uji_data, 'pembimbing1'),
            $formatDosen($tugasAkhir->bimbing_uji_data, 'pembimbing2'),
            $formatDosen($tugasAkhir->bimbing_uji_data, 'pengganti1') !== '-' ? $formatDosen($tugasAkhir->bimbing_uji_data, 'pengganti1') : $formatDosen($tugasAkhir->bimbing_uji_data, 'penguji1'),
            $formatDosen($tugasAkhir->bimbing_uji_data, 'pengganti2') !== '-' ? $formatDosen($tugasAkhir->bimbing_uji_data, 'pengganti2') : $formatDosen($tugasAkhir->bimbing_uji_data, 'penguji2'),
            $tugasAkhir->tanggal ?? '-',
            $tugasAkhir->jam ?? '-',
            $tugasAkhir->tempat ?? '-',
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
        $sheet->getColumnDimension('J')->setWidth(30);
        $sheet->getColumnDimension('K')->setWidth(30);
        $sheet->getColumnDimension('L')->setWidth(30);
        $sheet->getColumnDimension('M')->setWidth(30);
        $sheet->getStyle('G:J')->getAlignment()->setWrapText(true);
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
