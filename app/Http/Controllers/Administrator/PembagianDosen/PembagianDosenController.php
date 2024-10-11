<?php

namespace App\Http\Controllers\Administrator\PembagianDosen;

use App\Models\TugasAkhir;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PembagianDosenController extends Controller
{
    public function index()
    {
        $query =  TugasAkhir::with(['mahasiswa','bimbing_uji','periode_ta','topik','jenis_ta'])->where('status', 'acc')->where('is_completed', true)->get();
        $data = [
            'title' => 'Pembagian Dosen',
            'mods' => 'pembagian_dosen',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Tugas Akhir',
                    'is_active' => true,
                ],
                [
                    'title' => 'Pembagian Dosen',
                    'is_active' => true,
                ],
            ],
            'data' => $query,
        ];

        return view('administrator.pembagian-dosen.index', $data);
    }

    public function notCompleted()
    {
        $query =  TugasAkhir::with(['mahasiswa','bimbing_uji','periode_ta','topik','jenis_ta'])->where('status', 'acc')->where('is_completed', false)->get();
        $data = [
            'title' => 'Pembagian Dosen',
            'mods' => 'pembagian_dosen',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Tugas Akhir',
                    'is_active' => true,
                ],
                [
                    'title' => 'Pembagian Dosen',
                    'is_active' => true,
                ],
            ],
            'data' => $query,
        ];

        return view('administrator.pembagian-dosen.belum-dibagi', $data);
    }
}
