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
        
        $tanggalTabs = [];
        $currentDate = Carbon::now();
        while (count($tanggalTabs) < 5) {
            if ($currentDate->isWeekday()) {
                $tanggalTabs[] = $currentDate->format('d-m-Y');
            }
            $currentDate->addDay();
        }
        
        $activeTab = $request->get('active_tab', 'pra_seminar');
        $tanggal = $request->get('tanggal');
        if (!$tanggal || !in_array($tanggal, $tanggalTabs)) {
            $tanggal = $tanggalTabs[0];
        }

        $tanggalMulai = Carbon::createFromFormat('d-m-Y', $tanggal)->startOfDay();
        $tanggalAkhir = Carbon::createFromFormat('d-m-Y', $tanggal)->endOfDay();
        if ($activeTab === 'pra_seminar') {
            $jadwal = JadwalSeminar::with(['tugas_akhir.mahasiswa'])->where('status','sudah_terjadwal')->whereHas('tugas_akhir',function($q) {
                $q->where('status','acc');
            })->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir])->whereRaw('DAYOFWEEK(tanggal) NOT IN (1, 7)')->take(5)->get();
            $jadwal = $jadwal->map(function ($item) {
                $ta = $item->tugas_akhir;
                $posterSeminar = Pemberkasan::where('tugas_akhir_id', $ta->id)->whereHas('jenisDokumen', function ($query) {
                    $query->whereNama('POSTER SEMINAR')->whereIn('jenis', ['seminar', 'pra_seminar']);
                })->pluck('filename')->first();
                $jamMulai = $item->jam_mulai ? date('H:i', strtotime($item->jam_mulai)) : '-:-';
                $jamSelesai = $item->jam_selesai ? date('H:i', strtotime($item->jam_selesai)) : '-:-';
                $tipe = $ta->tipe == 'I' ? 'Individu' : 'Kelompok';
                $jenis = $ta->jenis_ta->nama_jenis ?? '-';
                $topik = $ta->topik->nama_topik ?? '-';
                
                $bimbingUji = $ta->bimbing_uji->mapWithKeys(function ($bimbing) {
                    return [
                        "{$bimbing->jenis}_{$bimbing->urut}" => $bimbing->dosen->name ?? '-',
                    ];
                });
                $item->judul_ta = $ta->judul ?? '-';
                $item->tipe = $tipe ?? '-';
                $item->poster = $posterSeminar ?? null;
                $item->jam = "$jamMulai - $jamSelesai" ?? '-';
                $item->topik = ($topik ?? '-') . ' - ' . ($jenis ?? '-');
                $item->nama = $ta->mahasiswa->nama_mhs ?? '-';
                $item->pembimbing_1 = $bimbingUji['pembimbing_1'] ?? '-';
                $item->pembimbing_2 = $bimbingUji['pembimbing_2'] ?? '-';
                $item->penguji_1 = $bimbingUji['penguji_1'] ?? '-';
                $item->penguji_2 = $bimbingUji['penguji_2'] ?? '-';
                return $item;
            });
        } elseif ($activeTab === 'pra_sidang') {
            $jadwal = Sidang::with(['tugas_akhir.mahasiswa'])->whereStatus('sudah_terjadwal')->whereHas('tugas_akhir',function($q) {
                $q->whereStatus('acc');
            })->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir])->whereRaw('DAYOFWEEK(tanggal) NOT IN (1, 7)')->take(5)->get();
            $jadwal = $jadwal->map(function ($item) {
                $ta = $item->tugas_akhir;
                $posterSidang = Pemberkasan::where('tugas_akhir_id', $ta->id)->whereHas('jenisDokumen', function ($query) {
                    $query->whereNama('POSTER SIDANG')->whereIn('jenis', ['sidang', 'pra_sidang']);
                })->pluck('filename')->first();
                $jamMulai = $item->jam_mulai ? date('H:i', strtotime($item->jam_mulai)) : '-:-';
                $jamSelesai = $item->jam_selesai ? date('H:i', strtotime($item->jam_selesai)) : '-:-';
                $tipe = $ta->tipe == 'I' ? 'Individu' : 'Kelompok';
                $jenis = $ta->jenis_ta->nama_jenis ?? '-';
                $topik = $ta->topik->nama_topik ?? '-';
                $bimbingUji = $ta->bimbing_uji->mapWithKeys(function ($bimbing) {
                    return [
                        "{$bimbing->jenis}_{$bimbing->urut}" => $bimbing->dosen->name ?? '-',
                    ];
                });
                $item->judul_ta = $ta->judul ?? '-';
                $item->tipe = $tipe ?? '-';
                $item->poster = $posterSidang ?? null;
                $item->jam = "$jamMulai - $jamSelesai" ?? '-';
                $item->topik = ($topik ?? '-') . ' - ' . ($jenis ?? '-');
                $item->nama = $ta->mahasiswa->nama_mhs ?? '-';
                $item->pembimbing_1 = $bimbingUji['pembimbing_1'] ?? '-';
                $item->pembimbing_2 = $bimbingUji['pembimbing_2'] ?? '-';
                $item->penguji_1 = isset($bimbingUji['pengganti_1']) ? $bimbingUji['pengganti_1'] : ($bimbingUji['penguji_1'] ?? '-');
                $item->penguji_2 = isset($bimbingUji['pengganti_2']) ? $bimbingUji['pengganti_2'] : ($bimbingUji['penguji_2'] ?? '-');
                $item->pengganti_1 = $bimbingUji['pengganti_1'] ?? '-';
                $item->pengganti_2 = $bimbingUji['pengganti_2'] ?? '-';                
                return $item;
            });
        }

        $tabs = $request->get('tabs', 'seminar');
        if($tabs === 'seminar') {
            $completes = JadwalSeminar::with(['tugas_akhir.mahasiswa'])->where('status','telah_seminar')->whereHas('tugas_akhir',function($q) {
                $q->where('status','acc');  
            })->take(5)->get();
            $completes = $completes->map(function ($item) {
                $ta = $item->tugas_akhir;
                $posterSeminar = Pemberkasan::where('tugas_akhir_id', $ta->id)->whereHas('jenisDokumen', function ($query) {
                    $query->whereNama('POSTER SEMINAR')->whereIn('jenis', ['seminar', 'pra_seminar']);
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
                $item->tipe = $tipe ?? '-';
                $item->poster = $posterSeminar ?? null;
                $item->topik = ($topik ?? '-') . ' - ' . ($jenis ?? '-');
                $item->nama = $ta->mahasiswa->nama_mhs ?? '-';
                $item->pembimbing_1 = $bimbingUji['pembimbing_1'] ?? '-';
                $item->pembimbing_2 = $bimbingUji['pembimbing_2'] ?? '-';
                $item->penguji_1 = $bimbingUji['penguji_1'] ?? '-';
                $item->penguji_2 = $bimbingUji['penguji_2'] ?? '-';
                return $item;
            });
        } elseif($tabs === 'sidang') {
            $completes = Sidang::with(['tugas_akhir.mahasiswa'])->where('status','sudah_sidang')->whereHas('tugas_akhir',function($q) {
                $q->where('status','acc');  
            })->take(5)->get();
            $completes = $completes->map(function ($item) {
                $ta = $item->tugas_akhir;
                $posterSidang = Pemberkasan::where('tugas_akhir_id', $ta->id)->whereHas('jenisDokumen', function ($query) {
                    $query->whereNama('POSTER SIDANG')->whereIn('jenis', ['sidang', 'pra_sidang']);
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
                $item->tipe = $tipe ?? '-';
                $item->poster = $posterSidang ?? null;
                $item->topik = ($topik ?? '-') . ' - ' . ($jenis ?? '-');
                $item->nama = $ta->mahasiswa->nama_mhs ?? '-';
                $item->pembimbing_1 = $bimbingUji['pembimbing_1'] ?? '-';
                $item->pembimbing_2 = $bimbingUji['pembimbing_2'] ?? '-';
                $item->penguji_1 = isset($bimbingUji['pengganti_1']) ? $bimbingUji['pengganti_1'] : ($bimbingUji['penguji_1'] ?? '-');
                $item->penguji_2 = isset($bimbingUji['pengganti_2']) ? $bimbingUji['pengganti_2'] : ($bimbingUji['penguji_2'] ?? '-');
                $item->pengganti_1 = $bimbingUji['pengganti_1'] ?? '-';
                $item->pengganti_2 = $bimbingUji['pengganti_2'] ?? '-'; 
                return $item;
            });
        }
        $data = [
            'title' => 'Beranda',
            'tawaran' => $tawaran,
            'tugasAkhir' => $tugasAkhir,
            'activeTab' => $activeTab,
            'jadwal' => $jadwal,
            'tanggalTabs' => $tanggalTabs,
            'tanggal' => $tanggal,
            'completed' => $completes,
            'tabs' => $tabs
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
        $tanggalTabs = [];
        $currentDate = Carbon::now();
        while (count($tanggalTabs) < 5) {
            if ($currentDate->isWeekday()) {
                $tanggalTabs[] = $currentDate->format('d-m-Y');
            }
            $currentDate->addDay();
        }
        
        $activeTab = $request->get('active_tab', 'pra_seminar');
        $tanggal = $request->get('tanggal');
        if (!$tanggal || !in_array($tanggal, $tanggalTabs)) {
            $tanggal = $tanggalTabs[0];
        }

        $tanggalMulai = Carbon::createFromFormat('d-m-Y', $tanggal)->startOfDay();
        $tanggalAkhir = Carbon::createFromFormat('d-m-Y', $tanggal)->endOfDay();
        if ($activeTab === 'pra_seminar') {
            $jadwal = JadwalSeminar::with(['tugas_akhir.mahasiswa'])->where('status','sudah_terjadwal')->whereHas('tugas_akhir',function($q) {
                $q->where('status','acc');
            })->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir])->whereRaw('DAYOFWEEK(tanggal) NOT IN (1, 7)')->paginate(1)->appends(['active_tab' => $activeTab, 'tanggal' => $tanggal]);
            $jadwal->getCollection()->transform(function ($item) {
                $ta = $item->tugas_akhir;
                $posterSeminar = Pemberkasan::where('tugas_akhir_id', $ta->id)->whereHas('jenisDokumen', function ($query) {
                    $query->whereNama('POSTER SEMINAR')->whereIn('jenis', ['seminar', 'pra_seminar']);
                })->pluck('filename')->first();
                $jamMulai = $item->jam_mulai ? date('H:i', strtotime($item->jam_mulai)) : '-:-';
                $jamSelesai = $item->jam_selesai ? date('H:i', strtotime($item->jam_selesai)) : '-:-';
                $tipe = $ta->tipe == 'I' ? 'Individu' : 'Kelompok';
                $jenis = $ta->jenis_ta->nama_jenis ?? '-';
                $topik = $ta->topik->nama_topik ?? '-';                
                $bimbingUji = $ta->bimbing_uji->mapWithKeys(function ($bimbing) {
                    return [
                        "{$bimbing->jenis}_{$bimbing->urut}" => $bimbing->dosen->name ?? '-',
                    ];
                });
                $item->judul_ta = $ta->judul ?? '-';
                $item->tipe = $tipe ?? '-';
                $item->poster = $posterSeminar ?? null;
                $item->jam = "$jamMulai - $jamSelesai" ?? '-';
                $item->topik = ($topik ?? '-') . ' - ' . ($jenis ?? '-');
                $item->nama = $ta->mahasiswa->nama_mhs ?? '-';
                $item->pembimbing_1 = $bimbingUji['pembimbing_1'] ?? '-';
                $item->pembimbing_2 = $bimbingUji['pembimbing_2'] ?? '-';
                $item->penguji_1 = $bimbingUji['penguji_1'] ?? '-';
                $item->penguji_2 = $bimbingUji['penguji_2'] ?? '-';
                return $item;
            });
        } elseif ($activeTab === 'pra_sidang') {
            $jadwal = Sidang::with(['tugas_akhir.mahasiswa'])->whereStatus('sudah_terjadwal')->whereHas('tugas_akhir',function($q) {
                $q->whereStatus('acc');
            })->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir])->whereRaw('DAYOFWEEK(tanggal) NOT IN (1, 7)')->paginate(10)->appends(['active_tab' => $activeTab, 'tanggal' => $tanggal]);
            $jadwal->getCollection()->transform(function ($item) {
                $ta = $item->tugas_akhir;
                $posterSidang = Pemberkasan::where('tugas_akhir_id', $ta->id)->whereHas('jenisDokumen', function ($query) {
                    $query->whereNama('POSTER SIDANG')->whereIn('jenis', ['sidang', 'pra_sidang']);
                })->pluck('filename')->first();
                $jamMulai = $item->jam_mulai ? date('H:i', strtotime($item->jam_mulai)) : '-:-';
                $jamSelesai = $item->jam_selesai ? date('H:i', strtotime($item->jam_selesai)) : '-:-';
                $tipe = $ta->tipe == 'I' ? 'Individu' : 'Kelompok';
                $jenis = $ta->jenis_ta->nama_jenis ?? '-';
                $topik = $ta->topik->nama_topik ?? '-';
                $bimbingUji = $ta->bimbing_uji->mapWithKeys(function ($bimbing) {
                    return [
                        "{$bimbing->jenis}_{$bimbing->urut}" => $bimbing->dosen->name ?? '-',
                    ];
                });
                $item->judul_ta = $ta->judul ?? '-';
                $item->tipe = $tipe ?? '-';
                $item->poster = $posterSidang ?? null;
                $item->jam = "$jamMulai - $jamSelesai" ?? '-';
                $item->topik = ($topik ?? '-') . ' - ' . ($jenis ?? '-');
                $item->nama = $ta->mahasiswa->nama_mhs ?? '-';
                $item->pembimbing_1 = $bimbingUji['pembimbing_1'] ?? '-';
                $item->pembimbing_2 = $bimbingUji['pembimbing_2'] ?? '-';
                $item->penguji_1 = isset($bimbingUji['pengganti_1']) ? $bimbingUji['pengganti_1'] : ($bimbingUji['penguji_1'] ?? '-');
                $item->penguji_2 = isset($bimbingUji['pengganti_2']) ? $bimbingUji['pengganti_2'] : ($bimbingUji['penguji_2'] ?? '-');
                $item->pengganti_1 = $bimbingUji['pengganti_1'] ?? '-';
                $item->pengganti_2 = $bimbingUji['pengganti_2'] ?? '-';                
                return $item;
            });
        }

        $tabs = $request->get('tabs', 'seminar');
        if($tabs === 'seminar') {
            $completes = JadwalSeminar::with(['tugas_akhir.mahasiswa'])->where('status','telah_seminar')->whereHas('tugas_akhir',function($q) {
                $q->where('status','acc');  
            })->paginate(10)->appends(['tabs' => $tabs]);
            $completes->getCollection()->transform(function ($item) {
                $ta = $item->tugas_akhir;
                $posterSeminar = Pemberkasan::where('tugas_akhir_id', $ta->id)->whereHas('jenisDokumen', function ($query) {
                    $query->whereNama('POSTER SEMINAR')->whereIn('jenis', ['seminar', 'pra_seminar']);
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
                $item->tipe = $tipe ?? '-';
                $item->poster = $posterSeminar ?? null;
                $item->topik = ($topik ?? '-') . ' - ' . ($jenis ?? '-');
                $item->nama = $ta->mahasiswa->nama_mhs ?? '-';
                $item->pembimbing_1 = $bimbingUji['pembimbing_1'] ?? '-';
                $item->pembimbing_2 = $bimbingUji['pembimbing_2'] ?? '-';
                $item->penguji_1 = $bimbingUji['penguji_1'] ?? '-';
                $item->penguji_2 = $bimbingUji['penguji_2'] ?? '-';
                return $item;
            });

        } elseif($tabs === 'sidang') {
            $completes = Sidang::with(['tugas_akhir.mahasiswa'])->where('status','sudah_sidang')->whereHas('tugas_akhir',function($q) {
                $q->where('status','acc');  
            })->paginate(10)->appends(['tabs' => $tabs]);
            $completes->getCollection()->transform(function ($item) {
                $ta = $item->tugas_akhir;
                $posterSidang = Pemberkasan::where('tugas_akhir_id', $ta->id)->whereHas('jenisDokumen', function ($query) {
                    $query->whereNama('POSTER SIDANG')->whereIn('jenis', ['sidang', 'pra_sidang']);
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
                $item->tipe = $tipe ?? '-';
                $item->poster = $posterSidang ?? null;
                $item->topik = ($topik ?? '-') . ' - ' . ($jenis ?? '-');
                $item->nama = $ta->mahasiswa->nama_mhs ?? '-';
                $item->pembimbing_1 = $bimbingUji['pembimbing_1'] ?? '-';
                $item->pembimbing_2 = $bimbingUji['pembimbing_2'] ?? '-';
                $item->penguji_1 = isset($bimbingUji['pengganti_1']) ? $bimbingUji['pengganti_1'] : ($bimbingUji['penguji_1'] ?? '-');
                $item->penguji_2 = isset($bimbingUji['pengganti_2']) ? $bimbingUji['pengganti_2'] : ($bimbingUji['penguji_2'] ?? '-');
                $item->pengganti_1 = $bimbingUji['pengganti_1'] ?? '-';
                $item->pengganti_2 = $bimbingUji['pengganti_2'] ?? '-'; 
                return $item;
            });
        }

        $data = [
            'title' => 'Jadwal',
            'activeTab' => $activeTab,
            'jadwal' => $jadwal,
            'tanggalTabs' => $tanggalTabs,
            'tanggal' => $tanggal,
            'completed' => $completes,
            'tabs' => $tabs
        ];

        return view('jadwal.index', $data);
    }
}
