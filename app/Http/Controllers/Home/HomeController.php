<?php

namespace App\Http\Controllers\Home;

use Carbon\Carbon;
use App\Models\Sidang;
use App\Models\PeriodeTa;
use App\Models\TugasAkhir;
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
        } elseif ($activeTab === 'pra_sidang') {
            $jadwal = Sidang::get();
        }

        $tabs = $request->get('tabs', 'seminar');
        if($tabs === 'seminar') {
            $completes = JadwalSeminar::with(['tugas_akhir.mahasiswa'])->where('status','telah_seminar')->whereHas('tugas_akhir',function($q) {
                $q->where('status','acc');  
            })->take(5)->get();
        } elseif($tabs === 'sidang') {
            $completes = Sidang::with(['tugas_akhir.mahasiswa'])->where('status','sudah_sidang')->whereHas('tugas_akhir',function($q) {
                $q->where('status','acc');  
            })->take(5)->get();
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

    private function statistic()
    {
        $statistic = TugasAkhir::with(['jenis_ta','topik','bimbing_uji','mahasiswa'])->where('status','acc')->get();
    }
}
