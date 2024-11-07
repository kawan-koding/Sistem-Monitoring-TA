<?php

namespace App\Http\Controllers\Home;

use App\Models\PeriodeTa;
use App\Models\TugasAkhir;
use Illuminate\Http\Request;
use App\Models\RekomendasiTopik;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $tawaran = RekomendasiTopik::with(['dosen'])->where('status','Disetujui')->where('kuota', '!=', 0)->latest()->take(5)->get();
        $tugasAkhir = TugasAkhir::with(['topik','mahasiswa','jenis_ta','bimbing_uji'])->where('status','acc')->latest()->take(5)->get();
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
        $tawaran = RekomendasiTopik::with(['dosen'])->where('status','Disetujui')->where('kuota', '!=', 0)->when($search, function ($query) use ($search) {
            return $query->where('judul', 'LIKE', '%' . $search . '%');
        })->get();
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
