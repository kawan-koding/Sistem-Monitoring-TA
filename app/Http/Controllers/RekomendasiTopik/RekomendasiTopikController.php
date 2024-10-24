<?php

namespace App\Http\Controllers\RekomendasiTopik;

use Illuminate\Http\Request;
use App\Models\RekomendasiTopik;
use App\Http\Controllers\Controller;

class RekomendasiTopikController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $tawaran = RekomendasiTopik::with(['dosen'])->where('status','Disetujui')->where('kuota', '!=', 0)->when($search, function ($query) use ($search) {
            return $query->where('judul', 'LIKE', '%' . $search . '%');
        })->latest()->get();
        $data = [
            'title' => 'Tawaran Topik',
            'tawaran' => $tawaran,
        ];

        return view('rekomendasi-topik.index', $data);
    }
}
