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
        $kaprodi = null;
        if(getInfoLogin()->hasRole('Mahasiswa')){
            $dataMahasiswa = $this->mahasiswa();
        }
        if(getInfoLogin()->hasRole('Admin')){
            $admin = $this->admin();
        }

        if(session('switchRoles') == 'Kaprodi'){
            $kaprodi = $this->kaprodi();
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
            'kaprodi' => $kaprodi,
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

    private function kaprodi()
    {
        $user = getInfoLogin()->userable;
        $prodi = $user->programStudi->id;
        $belumAcc = RekomendasiTopik::where('status','Menunggu')->get();
        $sudahAcc = RekomendasiTopik::where('status','Disetujui')->get();
        $taDraft = TugasAkhir::where('status','draft')->whereHas('mahasiswa', function($query) use ($prodi) {
            $query->where('program_studi_id', $prodi);
        })->get();
        $taAcc = TugasAkhir::where('status','acc')->whereHas('mahasiswa', function($query) use ($prodi) {
            $query->where('program_studi_id', $prodi);
        })->get();
        return [
            'belumAcc' => $belumAcc,
            'sudahAcc' => $sudahAcc,
            'taDraft' => $taDraft,
            'taAcc' => $taAcc
        ];
    }
}
