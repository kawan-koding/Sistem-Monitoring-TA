<?php

namespace App\Http\Controllers\Administrator\Jadwal;

use App\Models\PeriodeTa;
use App\Models\BimbingUji;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JadwalController extends Controller
{
    public function index()
    {
        $user = getInfoLogin()->userable;
        $periode = PeriodeTa::where('is_active', 1)->first();
        $query = [];
        if(getInfoLogin()->hasRole('Dosen')) {
            $query = BimbingUji::with(['tugas_akhir','dosen'])->where('dosen_id', $user->id)->whereHas('tugas_akhir', function($q) use ($periode) {
                $q->where('periode_ta_id', $periode->id);
            })->get();
            
            dd(json_encode($query, JSON_PRETTY_PRINT));
        }
        $data = [
            'title' => 'Jurusan',
            'mods' => 'jurusan',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Master Data',
                    'is_active' => true
                ],
                [
                    'title' => 'Jurusan',
                    'is_active' => true
                ]
            ],
            'data' => $query,
        ];
        return view('administrator.jadwal.index', $data);
    }
}
