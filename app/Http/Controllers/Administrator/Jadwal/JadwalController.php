<?php

namespace App\Http\Controllers\Administrator\Jadwal;

use App\Models\PeriodeTa;
use App\Models\BimbingUji;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\JadwalSeminar;

class JadwalController extends Controller
{
    public function index($jenis = 'pembimbing')
    {
        $user = getInfoLogin()->userable;
        $periode = PeriodeTa::where('is_active', 1)->first();
        $query = [];
        if(getInfoLogin()->hasRole('Dosen')) {
            $query = BimbingUji::where('dosen_id', $user->id)->where('jenis', $jenis)->whereHas('tugas_akhir', function($q) use ($periode) {
                $q->where('periode_ta_id', $periode->id);
            })->get();
        }
        $data = [
            'title' => 'Jadwal',
            'mods' => 'jadwal',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Jadwal',
                    'is_active' => true
                ]
            ],
            'data' => $query,
        ];
        return view('administrator.jadwal.index', $data);
    }

    public function rating(JadwalSeminar $jadwal)
    {
        $data = [
            'title' => 'Jadwal Seminar',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard'),
                ],
                [
                    'title' => 'Tugas Akhir',
                    'is_active' => true,
                ],
                [
                    'title' => 'Jadwal Seminar',
                    'is_active' => true,
                ],
                [
                    'title' => 'Detail Penilaian',
                    'is_active' => true
                ]
            ],
            'data' => $jadwal
        ];
        
        return view('administrator.jadwal.nilai', $data);
    }

    // public function revisi(Request $request,JadwalSeminar $jadwal)
    // {
    //     dd($request->all());
    // }
}
