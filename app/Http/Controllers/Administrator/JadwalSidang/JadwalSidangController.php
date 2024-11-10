<?php

namespace App\Http\Controllers\Administrator\JadwalSidang;

use App\Models\Sidang;
use App\Models\Mahasiswa;
use App\Models\PeriodeTa;
use App\Models\JenisDokumen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JadwalSidangController extends Controller
{
    public function index(Request $request)
    {
        $query = [];
        $periode = PeriodeTa::where('is_active', 1)->first();

        if(getInfoLogin()->hasRole('Mahasiswa')) {
            $myId = getInfoLogin()->userable;
            $mahasiswa = Mahasiswa::where('id', $myId->id)->first();
            if($mahasiswa) {
                $query = Sidang::whereHas('tugas_akhir', function ($q) use($periode, $mahasiswa) {
                    $q->where('periode_ta_id', $periode->id)->where('mahasiswa_id', $mahasiswa->id);
                })->get();
            }
        }

        $docSeminar = JenisDokumen::whereIn('jenis', ['seminar', 'pra_seminar'])->get();
        $data = [
            'title' =>  'Jadwal Sidang',
            'breadcrumbs' =>[
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Jadwal Sidang',
                    'is_active' => true,
                ]
            ],
            'data' => $query,
            'document_seminar' => $docSeminar,
        ];
        
        return view('administrator.jadwal-sidang.index', $data);
    }
}
