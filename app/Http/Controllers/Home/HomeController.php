<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Models\RekomendasiTopik;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $tawaran = RekomendasiTopik::with(['dosen'])->where('status','Disetujui')->where('kuota', '!=', 0)->latest()->take(5)->get();
        $data = [
            'title' => 'Beranda',
            'tawaran' => $tawaran,
        ];
    
        return view('index', $data);
    }
}
