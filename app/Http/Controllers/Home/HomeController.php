<?php

namespace App\Http\Controllers\Home;

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
        $tugasAkhir = TugasAkhir::with(['topik','mahasiswa','jenis_ta','bimbing_uji'])->where('status','acc')->latest()->paginate(2, ['*'], 'tugas_akhir_page', $request->get('tugas_akhir_page', 1));

        $selectedDate = now();  // You can replace this with logic to dynamically select a date
        $tab = $request->get('tab', 'seminar');  // Get the selected tab, default to 'seminar'

        // Generate the next 5 weekdays (working days)
        $weekdays = [];
        for ($i = 1; count($weekdays) < 5; $i++) {
            $nextDay = $selectedDate->copy()->addDays($i);
            if ($nextDay->isWeekend()) {
                continue;  // Skip weekends
            }
            $weekdays[] = $nextDay->toDateString();
        }

        // Filter seminar or sidang data
        if ($tab == 'seminar') {
            $jadwalSeminar = JadwalSeminar::whereIn('tanggal', $weekdays)->get();
        }

        // For 'sidang' tab
        $jadwalSidang = Sidang::whereIn('tanggal', $weekdays)->get();
        
        $data = [
            'title' => 'Beranda',
            'tawaran' => $tawaran,
            'tugasAkhir' => $tugasAkhir,
            'jadwalSeminar' => $jadwalSeminar,
            'jadwalSidang' => $jadwalSidang,
            'weekdays' => $weekdays,
            'tab' => $tab,
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
        })->paginate(10);
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
        })->get();
        $data = [
            'title' => 'Tugas Akhir',
            'query' => $query,
        ];

        return view('tugas-akhir.index', $data);
    }
}
