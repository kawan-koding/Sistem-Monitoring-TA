<?php

namespace App\Http\Controllers\Administrator\DaftarBimbingan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DaftarBimbinganController extends Controller
{
    public function index()
    {
        $query = [];
        $data = [
            'title' => 'Mahasiswa Bimbingan',
            'mods' => 'daftar_bimbingan',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard'),
                ],
                [
                    'title' => 'Daftar Bimbingan',
                    'is_active' => true,
                ],
            ],
            'data' => $query,
        ];
        
        return view('administrator.daftar-bimbingan.index');
    }
}
