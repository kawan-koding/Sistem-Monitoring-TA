<?php

namespace App\Http\Controllers\Administrator\Dashboard;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\PeriodeTa;
use App\Models\BimbingUji;
use App\Models\KuotaDosen;
use App\Models\TugasAkhir;
use Illuminate\Http\Request;
use App\Models\RekomendasiTopik;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $dataMahasiswa = null;
        $admin = null;
        $kaprodi = null;
        $dosen = null;
        if(getInfoLogin()->hasRole('Mahasiswa')){
            $dataMahasiswa = $this->mahasiswa();
        }
        if(getInfoLogin()->hasRole('Admin')){
            $admin = $this->admin();
        }

        if(session('switchRoles') == 'Kaprodi'){
            $kaprodi = $this->kaprodi();
        }
        
        if(session('switchRoles') == 'Dosen' && getInfoLogin()->hasRole('Dosen')){
            $dosen = $this->dosen();
        }

        $data = [
            'title' => 'Dashboard',
            'mods' => 'dashboard',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'is_active' => true
                ],
            ],
            'dataMahasiswa' => $dataMahasiswa,
            'admin' => $admin,
            'kaprodi' => $kaprodi,
            'dosen' => $dosen,
        ];

        return view('administrator.dashboard.index', $data);
    }

    private function mahasiswa()
    {
        $mhs = getInfoLogin()->userable;
        $prodi = $mhs->programStudi;
        $topik = RekomendasiTopik::where('status', 'Disetujui')->whereHas('ambilTawaran', function ($q) {
                $q->where('status', 'Disetujui');
            }, '<', DB::raw('kuota'))->where('program_studi_id', $prodi->id)->take(3)->get();
        $tugasAkhir = TugasAkhir::with(['mahasiswa','jenis_ta','topik','periode_ta','bimbing_uji'])->where('mahasiswa_id', $mhs->id)->latest()->first();
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
        $tugasAkhir = TugasAkhir::where('status', 'acc');
        $topik = TugasAkhir::whereStatus('draft');

        return [
            'dosen' => $dosen,
            'mhs' => $mhs,
            'ta' => $tugasAkhir,
            'topik' => $topik
        ];
    }


    private function kaprodi()
    {
        $user = getInfoLogin()->userable;
        $prodi = $user->programStudi->id;
        $belumAcc = RekomendasiTopik::where('status','Menunggu')->where('program_studi_id', $prodi)->get();
        $sudahAcc = RekomendasiTopik::where('status','Disetujui')->where('program_studi_id', $prodi)->get();
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

    private function dosen()
    {
        $user = getInfoLogin()->userable;
        $bimbing = BimbingUji::where('dosen_id', $user->id)->where('jenis', 'pembimbing');
        $uji = BimbingUji::where('dosen_id', $user->id)->where('jenis', 'penguji');
        $periode = PeriodeTa::where('is_active', 1)->first();
        $kuota = KuotaDosen::where('periode_ta_id', $periode->id)->where('dosen_id', $user->id)->first();
        // $totalKuota = $kuota->sum(function ($item) {
        //     return $item->pembimbing_1 + $item->pembimbing_2 + $item->penguji_1 + $item->penguji_2;
        // });
        return[
            'bimbing' => $bimbing,
            'uji' => $uji,
            'kuota' => $kuota,
        ];

    }
}
