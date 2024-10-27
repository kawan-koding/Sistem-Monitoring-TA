<?php

namespace App\Http\Controllers\Administrator\Template;

use Illuminate\Http\Request;
use App\Models\JadwalSeminar;
use App\Http\Controllers\Controller;

class TemplateController extends Controller
{
    public function revisi(JadwalSeminar $jadwal) 
    {
        $jdwl = JadwalSeminar::with(['tugas_akhir.bimbing_uji.revisi.bimbingUji.dosen','tugas_akhir.bimbing_uji.revisi.bimbingUji.tugas_akhir.mahasiswa'])->findOrFail($jadwal->id);
        $allRevisis = $jdwl->tugas_akhir->bimbing_uji->flatMap(function ($bimbingUji) {
            if ($bimbingUji->revisi->isEmpty()) {
                return [];
            }
            return $bimbingUji->revisi->map(function ($revisi) use ($bimbingUji) {
                return [
                    'revisi' => $revisi,
                    'dosen' => $bimbingUji->dosen,
                ];
            });
        })->toArray();
        // dd($allRevisis);
        $bu = $jadwal->tugas_akhir->bimbing_uji()->where('jenis','pembimbing')->orderBy('urut', 'asc')->get();
        $data = [
            'title' => 'Lembar Revisi',
            'jadwal' => $jdwl,
            'rvs' => $allRevisis,
            'bimbingUji' => $bu,
        ];

        return view('administrator.template.revisi', $data);
    }

    public function lembarPenilaian()
    {
        $data = [
            'title' => 'Cetak Lembar Penilaian',
        ];

        return view('administrator.template.lembar-penilaian');
    }
}
