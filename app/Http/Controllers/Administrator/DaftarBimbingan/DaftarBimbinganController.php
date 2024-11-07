<?php

namespace App\Http\Controllers\Administrator\DaftarBimbingan;

use App\Models\PeriodeTa;
use App\Models\BimbingUji;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DaftarBimbinganController extends Controller
{
    public function index(Request $request)
    {
        $query = [];
        $user = getInfoLogin()->userable;
        $periode = PeriodeTa::where('is_active', 1)->first();
        $query = BimbingUji::with(['tugas_akhir', 'dosen'])->where('dosen_id', $user->id)->whereHas('tugas_akhir', function($q) use ($periode){
            $q->where('periode_ta_id', $periode->id)->whereIn('status', ['acc','draft']);
        });
        if ($request->status == 'mahasiswa_uji') {
            $query->where('jenis', 'penguji');
        } else {
            $query->where('jenis', 'pembimbing');
        }
        $query = $query->get();
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
        
        return view('administrator.daftar-bimbingan.index', $data);
    }

    public function show(BimbingUji $bimbingUji)
    {
        $query = $bimbingUji->tugas_akhir;
        $ta = BimbingUji::where('tugas_akhir_id', $query->id)->get();
        $bimbingUji->load('tugas_akhir.mahasiswa','dosen','tugas_akhir.periode_ta');
        $pembimbing1 = $ta->where('jenis', 'pembimbing')->where('urut', 1)->first();
        $pembimbing2 = $ta->where('jenis', 'pembimbing')->where('urut', 2)->first();
        $penguji1 = $ta->where('jenis', 'penguji')->where('urut', 1)->first();
        $penguji2 = $ta->where('jenis', 'penguji')->where('urut', 2)->first();
        
        $data = [
            'title' => 'Detail Daftar Bimbingan',
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
            'pembimbingPenguji' => $bimbingUji,
            'pembimbing1' => $pembimbing1,
            'pembimbing2' => $pembimbing2,
            'penguji1' => $penguji1,
            'penguji2' => $penguji2, 
        ];
        return view('administrator.daftar-bimbingan.show', $data);
    }
}
