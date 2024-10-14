<?php

namespace App\Http\Controllers\Administrator\JadwalSeminar;

use App\Http\Controllers\Controller;
use App\Models\TugasAkhir;
use Illuminate\Http\Request;

class JadwalSeminarController extends Controller
{
    public function index()
    {
        $query = [];
        if(getInfoLogin()->hasRole('Admin')) {
            $query = TugasAkhir::with(['jenis_ta', 'topik', 'mahasiswa', 'bimbing_uji'])->where('status', 'acc')->get();
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
}
