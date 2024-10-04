<?php

namespace App\Http\Controllers\Administrator\DaftarTA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DaftarTAController extends Controller
{
    public function index()
    {
        if (Auth::user()->hasRoles('Developer')) {
            $dataTa = TugasAkhir::with(['jenis_ta', 'topik'])->get();    
        }
        if (Auth::user()->hasRoles('Admin')) {
            $dataTa = TugasAkhir::with(['jenis_ta', 'topik'])->where('status', '!=', 'draft')->get();    
        }
        if (Auth::user()->hasRoles('Kaprodi')) {
            $dataTa = TugasAkhir::with(['jenis_ta', 'topik'])->get();
        }

        $data = [
            'title' => 'Daftar Tugas Akhir',
            'mods' => 'daftar_ta',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Tugas Akhir',
                    'is_active' => true
                ],[
                    'title' => 'Daftar Tugas Akhir',
                    'is_active' => true
                ]
            ],
            'dataTA' => $dataTa,
        ];
        
        return view('administrator.daftar-ta.index', $data);
    }

}
