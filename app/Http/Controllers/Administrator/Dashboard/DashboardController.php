<?php

namespace App\Http\Controllers\Administrator\Dashboard;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\TugasAkhir;
use Illuminate\Http\Request;
use App\Models\RekomendasiTopik;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $dataMahasiswa = null;
        $admin = null;
        if(getInfoLogin()->hasRole('Mahasiswa')){
            $dataMahasiswa = $this->mahasiswa();
        }
        if(getInfoLogin()->hasRole('Admin')){
            $admin = $this->admin();
        }

        $data = [
            'title' => 'Dashboard',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'is_active' => true
                ],
            ],
            'dataMahasiswa' => $dataMahasiswa,
            'admin' => $admin,
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

    private function admin()
    {
        $dosen = Dosen::all();
        $mhs = Mahasiswa::all();
        $tugasAkhir = TugasAkhir::all();

        return [
            'dosen' => $dosen,
            'mhs' => $mhs,
            'ta' => $tugasAkhir
        ];
    }
}
