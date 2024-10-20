<?php

namespace App\Http\Controllers\Administrator\Dashboard;

use App\Models\TugasAkhir;
use Illuminate\Http\Request;
use App\Models\RekomendasiTopik;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $dataMahasiswa = $this->mahasiswa();
        $data = [
            'title' => 'Dashboard',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'is_active' => true
                ],
            ],
            'dataMahasiswa' => $dataMahasiswa,
        ];

        return view('administrator.dashboard.index', $data);
    }

    private function mahasiswa()
    {
        $mhs = getInfoLogin()->userable;
        $topik = RekomendasiTopik::where('status', 'Disetujui')->where('kuota', '!=', 0)->latest()->take(3)->get();
        $tugasAkhir = TugasAkhir::with(['mahasiswa','jenis_ta','topik','periode_ta','bimbing_uji'])->where('mahasiswa_id', $mhs->id)->first();
        return [
            'mhs' => $mhs,
            'topik' => $topik,
            'tugasAkhir' => $tugasAkhir
        ];
    }
}
