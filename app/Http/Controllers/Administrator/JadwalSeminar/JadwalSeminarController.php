<?php

namespace App\Http\Controllers\Administrator\JadwalSeminar;

use App\Http\Controllers\Controller;
use App\Models\JadwalSeminar;
use App\Models\TugasAkhir;
use Illuminate\Http\Request;

class JadwalSeminarController extends Controller
{
    public function index()
    {
        $query = [];
        $periode = PeriodeTa::where('is_active', 1)->first();
        if(getInfoLogin()->hasRole('Admin')) {
            $query = JadwalSeminar::with(['tugas_akhir.mahasiswa', 'tugas_akhir.topik','tugas_akhir.jenis_ta', 'tugas_akhir.bimbing_uji', 'ruangan', 'hari'])
            ->whereHas('tugas_akhir', function ($q) use($periode) { 
                $q->where('status', 'acc')->where('periode_ta_id', $periode->id); 
            })->get();
            // dd($query);
        }

        $data = [
            'title' =>  'Jadwal Seminar',
            'breadcrumbs' =>[
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Tugas Akhir',
                    'is_active' => true,
                ],
                [
                    'title' => 'Jadwal Seminar',
                    'is_active' => true,
                ]
                ],
            'data' => $query,
        ];

        return view('administrator.jadwal-seminar.index', $data);
    }

    // public function edit(JadwalSeminar $jadwalSeminar)
    // {
        
    // }
}
