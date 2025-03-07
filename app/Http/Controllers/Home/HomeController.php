<?php

namespace App\Http\Controllers\Home;

use Carbon\Carbon;
use App\Models\Sidang;
use App\Models\PeriodeTa;
use App\Models\TugasAkhir;
use App\Models\Pemberkasan;
use App\Models\JenisDokumen;
use Illuminate\Http\Request;
use App\Models\JadwalSeminar;
use App\Models\RekomendasiTopik;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $tawaran = RekomendasiTopik::where('status', 'Disetujui')->whereHas('ambilTawaran', function ($q) {
            $q->where('status', 'Disetujui');
        }, '<', DB::raw('kuota'))->take(5)->get();
        $tugasAkhir = TugasAkhir::with(['topik','mahasiswa','jenis_ta','bimbing_uji'])->where('status','acc')->take(5)->get();
    
        $data = [
            'title' => 'Beranda',
            'tawaran' => $tawaran,
            'tugasAkhir' => $tugasAkhir
        ];
    
        return view('index', $data);
    }

    public function topik(Request $request)
    {
        $search = $request->input('search');
        $tawaran = RekomendasiTopik::with(['dosen'])->where('status','Disetujui')->whereHas('ambilTawaran', function ($q) {
            $q->where('status', 'Disetujui');
        }, '<', DB::raw('kuota'))->when($search, function ($query) use ($search) {
            return $query->where('judul', 'LIKE', '%' . $search . '%');
        })->paginate(10)->appends(['search' => $search]);
        $data = [
            'title' => 'Tawaran Topik',
            'tawaran' => $tawaran,
        ];

        return view('rekomendasi-topik.index', $data);
    }

    public function tugasAkhir(Request $request)
    {
        $search = $request->input('search');
        $periode = PeriodeTa::where('is_active', 1)->first();
        $query = TugasAkhir::with(['jenis_ta','topik','bimbing_uji','mahasiswa'])->where('periode_ta_id', $periode->id)->where('status','acc')->when($search, function ($query) use ($search) {
            return $query->where('judul', 'LIKE', '%' . $search . '%');
        })->paginate(10)->appends(['search' => $search]);
        $data = [
            'title' => 'Tugas Akhir',
            'query' => $query,
        ];

        return view('tugas-akhir.index', $data);
    }

    public function jadwal(Request $request)
    {
        $data = [
            'title' => 'Jadwal',
        ];

        return view('jadwal.index', $data);
    }

    protected function processJadwal($jadwal, $type)
    {
        return $jadwal->map(function ($item) use ($type) {
            $ta = $item->tugas_akhir;
            $poster = Pemberkasan::where('tugas_akhir_id', $ta->id)->whereHas('jenisDokumen', function ($query) use ($type) {
                $query->whereNama('POSTER ' . strtoupper($type))->whereIn('jenis', [$type, 'pra_' . $type]);
            })->pluck('filename')->first();

            $jamMulai = $item->jam_mulai ? date('H:i', strtotime($item->jam_mulai)) : '-:-';
            $jamSelesai = $item->jam_selesai ? date('H:i', strtotime($item->jam_selesai)) : '-:-';
            $bimbingUji = $ta->bimbing_uji->mapWithKeys(function ($bimbing) {
                return [
                    "{$bimbing->jenis}_{$bimbing->urut}" => $bimbing->dosen->name ?? '-',
                ];
            });

            $item->tanggal = $item->tanggal ? Carbon::parse($item->tanggal)->translatedFormat('d F Y') : '-';
            $item->jam = "$jamMulai - $jamSelesai" ?? '-';
            $item->poster = $poster ? asset('storage/files/pemberkasan/' . $poster) : null;
            $item->pembimbing_1 = $bimbingUji['pembimbing_1'] ?? '-';
            $item->pembimbing_2 = $bimbingUji['pembimbing_2'] ?? '-';
            if($type === 'seminar') {
                $item->penguji_1 = $bimbingUji['penguji_1'] ?? '-';
                $item->penguji_2 = $bimbingUji['penguji_2'] ?? '-';
            }
            if ($type === 'sidang') {
                $item->penguji_1 = isset($bimbingUji['pengganti_1']) ? $bimbingUji['pengganti_1'] : ($bimbingUji['penguji_1'] ?? '-');
                $item->penguji_2 = isset($bimbingUji['pengganti_2']) ? $bimbingUji['pengganti_2'] : ($bimbingUji['penguji_2'] ?? '-');
            }

            return $item;
        });
    }

    protected function fetchJadwal($type, $perHari)
    {
        $model = $type === 'seminar' ? JadwalSeminar::class : Sidang::class;
        $jadwal = $model::with(['tugas_akhir.mahasiswa.programStudi', 'ruangan', 'tugas_akhir.bimbing_uji'])->where('status', $type === 'seminar' ? 'sudah_terjadwal' : 'sudah_daftar')->whereHas('tugas_akhir', function ($q) {
            $q->where('status', 'acc');
        });
        if ($perHari) {
            $jadwal->whereDate('tanggal', Carbon::today());
        }
        $jadwal = $jadwal->orderBy('tanggal', 'asc')->orderBy('jam_mulai', 'asc')->whereNotNull('tanggal')->get();
        return $this->processJadwal($jadwal, $type);
    }


    public function getAllJadwal(Request $request)
    {
        $activeTab = $request->get('active_tab', 'pra_seminar');

        if ($activeTab === 'pra_seminar') {
            $jadwal = $this->fetchJadwal('seminar', false);
        } elseif ($activeTab === 'pra_sidang') {
            $jadwal = $this->fetchJadwal('sidang', false);
        } else {
            return response()->json([
                'message' => 'Tab tidak ditemukan',
                'data' => []
            ], 400);
        }

        return response()->json([
            'message' => 'success',
            'data' => $jadwal
        ]);
    }

    public function getJadwal(Request $request)
    {
        $activeTab = $request->get('active_tab', 'pra_seminar');

        if ($activeTab === 'pra_seminar') {
            $jadwal = $this->fetchJadwal('seminar', true);
        } elseif ($activeTab === 'pra_sidang') {
            $jadwal = $this->fetchJadwal('sidang', true);
        } else {
            return response()->json([
                'message' => 'Tab tidak ditemukan',
                'data' => []
            ], 400);
        }

        return response()->json([
            'message' => 'success',
            'data' => $jadwal
        ]);
    }

    // Daftar Mahasiswa
    protected function processDaftarMahasiswa($data, $type)
    {
        return $data->map(function ($item) use ($type) {
            $ta = $item->tugas_akhir;
            $poster = Pemberkasan::where('tugas_akhir_id', $ta->id)->whereHas('jenisDokumen', function ($query) use ($type) {
                $query->whereNama('POSTER ' . strtoupper($type))->whereIn('jenis', [$type, 'pra_' . $type]);
            })->pluck('filename')->first();

            $tipe = $ta->tipe == 'I' ? 'Individu' : 'Kelompok';
            $jenis = $ta->jenis_ta->nama_jenis ?? '-';
            $topik = $ta->topik->nama_topik ?? '-';
            $bimbingUji = $ta->bimbing_uji->mapWithKeys(function ($bimbing) {
                return [
                    "{$bimbing->jenis}_{$bimbing->urut}" => $bimbing->dosen->name ?? '-',
                ];
            });

            $item->judul_ta = $ta->judul ?? '-';
            $item->tipe = $tipe;
            $item->poster = $poster ? asset('storage/files/pemberkasan/' . $poster) : null;
            $item->topik = ($topik ?? '-') . ' - ' . ($jenis ?? '-');
            $item->nama = $ta->mahasiswa->nama_mhs ?? '-';
            $item->pembimbing_1 = $bimbingUji['pembimbing_1'] ?? '-';
            $item->pembimbing_2 = $bimbingUji['pembimbing_2'] ?? '-';

            if ($type === 'seminar') {
                $item->penguji_1 = $bimbingUji['penguji_1'] ?? '-';
                $item->penguji_2 = $bimbingUji['penguji_2'] ?? '-';
            }

            if ($type === 'sidang') {
                $item->penguji_1 = isset($bimbingUji['pengganti_1']) ? $bimbingUji['pengganti_1'] : ($bimbingUji['penguji_1'] ?? '-');
                $item->penguji_2 = isset($bimbingUji['pengganti_2']) ? $bimbingUji['pengganti_2'] : ($bimbingUji['penguji_2'] ?? '-');
            }

            return $item;
        });
    }

    protected function fetchDaftarMahasiswa($type)
    {
        $model = $type === 'seminar' ? JadwalSeminar::class : Sidang::class;
        $data = $model::with(['tugas_akhir.mahasiswa', 'tugas_akhir.bimbing_uji'])->where('status', $type === 'seminar' ? 'telah_seminar' : 'sudah_sidang')->whereHas('tugas_akhir', function ($q) {
            $q->where('status', 'acc');
        })->orderBy('tanggal', 'asc')->orderBy('jam_mulai', 'asc')->get();

        return $this->processDaftarMahasiswa($data, $type);
    }

    public function getDaftarMahasiswa(Request $request)
    {
        $tabs = $request->get('tabs', 'seminar');

        if ($tabs === 'seminar') {
            $data = $this->fetchDaftarMahasiswa('seminar');
        } elseif ($tabs === 'sidang') {
            $data = $this->fetchDaftarMahasiswa('sidang');
        } else {
            return response()->json([
                'message' => 'Tab tidak ditemukan',
                'data' => []
            ], 400);
        }

        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }


}
