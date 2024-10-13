<?php

namespace App\Http\Controllers\Administrator\DaftarTA;

use App\Models\Dosen;
use App\Models\Topik;
use App\Models\JenisTa;
use App\Models\PeriodeTa;
use App\Models\BimbingUji;
use App\Models\KuotaDosen;
use App\Models\TugasAkhir;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DaftarTAController extends Controller
{
    public function index()
    {
        $periode = PeriodeTa::where('is_active', 1)->first();
        $dataTa = TugasAkhir::with(['mahasiswa','bimbing_uji','periode_ta','topik','jenis_ta'])->where('periode_ta_id', $periode->id);    
        if (getInfoLogin()->hasRole('Admin')) {
            $dataTa->where('status', 'acc');
        }
        $dataTa = $dataTa->get();
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
                ],
                [
                    'title' => 'Daftar Tugas Akhir',
                    'is_active' => true
                ]
            ],
            'data' => $dataTa,
        ];
        
        return view('administrator.daftar-ta.index', $data);
    }

    public function show(TugasAkhir $tugasAkhir)
    {
         $data = [
            'title' => 'Detail  Tugas Akhir',
            'mods' => 'daftar_ta',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Tugas Akhir',
                    'is_active' => true
                ],
                [
                    'title' => 'Daftar Tugas Akhir',
                    'url' => route('apps.daftar-ta')
                ],
                [
                    'title' => 'Detail Tugas Akhir',
                    'is_active' => true
                ]
            ],
            'data' => [],
        ];
        
        return view('administrator.daftar-ta.index', $data);
    }

    public function edit(TugasAkhir $tugasAkhir)
    {
        $remapped = clone $tugasAkhir; 
        $remapped->load('mahasiswa','bimbing_uji','periode_ta','topik','jenis_ta');
        $pemb1 = $remapped->bimbing_uji()->where('urut', 1)->where('jenis','pembimbing')->first();
        $pemb2 = $remapped->bimbing_uji()->where('urut', 2)->where('jenis','pembimbing')->first();
        $peng1 = $remapped->bimbing_uji()->where('urut', 1)->where('jenis','penguji')->first();
        $peng2 = $remapped->bimbing_uji()->where('urut', 2)->where('jenis','penguji')->first();

        $bimbingUji = $tugasAkhir->bimbing_uji;
        $pembimbing = $bimbingUji->where('jenis', 'pembimbing')->sortBy('urut')->values();
        $penguji = $bimbingUji->where('jenis', 'penguji')->sortBy('urut')->values();
        $periode = PeriodeTa::where('is_active', true)->first();
        $dosen = Dosen::all()->map(function($dosen) use ($periode) {
            $kuota = KuotaDosen::where('dosen_id', $dosen->id)->where('periode_ta_id', $periode->id)->first();
            $totalPembimbing1 = BimbingUji::where('dosen_id', $dosen->id)->where('jenis', 'pembimbing')->where('urut', 1)->whereHas('tugas_akhir', function($query) use ($periode) {
                                    $query->where('periode_ta_id', $periode->id);
                                })->count();
            $totalPembimbing2 = BimbingUji::where('dosen_id', $dosen->id)->where('jenis', 'pembimbing')->where('urut', 2)->whereHas('tugas_akhir', function($query) use ($periode) {
                                    $query->where('periode_ta_id', $periode->id);
                                })->count();
            $totalPenguji1 = BimbingUji::where('dosen_id', $dosen->id)->where('jenis', 'penguji')->where('urut', 1)->whereHas('tugas_akhir', function($query) use ($periode) {
                                $query->where('periode_ta_id', $periode->id);
                            })->count();
            $totalPenguji2 = BimbingUji::where('dosen_id', $dosen->id)->where('jenis', 'penguji')->where('urut', 2)->whereHas('tugas_akhir', function($query) use ($periode) {
                                $query->where('periode_ta_id', $periode->id);
                            })->count();
            return (object)[
                'id' => $dosen->id,
                'nama' => $dosen->name,
                'kuota_pemb_1' => $kuota->pembimbing_1 ?? 0,
                'kuota_pemb_2' => $kuota->pembimbing_2 ?? 0,
                'kuota_peng_1' => $kuota->penguji_1 ?? 0,
                'kuota_peng_2' => $kuota->penguji_2 ?? 0,
                'total_pemb_1' => $totalPembimbing1,
                'total_pemb_2' => $totalPembimbing2,
                'total_peng_1' => $totalPenguji1,
                'total_peng_2' => $totalPenguji2,
                'sisa_pemb_1' => max(0, ($kuota->pembimbing_1 ?? 0) - $totalPembimbing1),
                'sisa_pemb_2' => max(0, ($kuota->pembimbing_2 ?? 0) - $totalPembimbing2),
                'sisa_peng_1' => max(0, ($kuota->penguji_1 ?? 0) - $totalPenguji1),
                'sisa_peng_2' => max(0, ($kuota->penguji_2 ?? 0) - $totalPenguji2),
            ];
        });

        $data = [
            'title' => 'Edit Tugas Akhir',
            'mods' => 'daftar_ta',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Tugas Akhir',
                    'is_active' => true
                ],
                [
                    'title' => 'Daftar Tugas Akhir',
                    'url' => route('apps.daftar-ta')
                ],
                [
                    'title' => 'Edit Tugas Akhir',
                    'is_active' => true
                ]
            ],
            'pembimbing' => $pembimbing,
            'penguji' => $penguji,
            'dosen' => $dosen,
            'data' => $remapped,
            'pemb1' => $pemb1,
            'pemb2' => $pemb2,
            'peng1' => $peng1,
            'peng2' => $peng2,
            'jenis' => JenisTa::all(),
            'topik' => Topik::all(),
            'action' => route('apps.daftar-ta.update', $tugasAkhir->id),
        ];
        
        return view('administrator.daftar-ta.form', $data);
    }

    public function update(Request $request, TugasAkhir $tugasAkhir)
    {
        
    }

    public function destroy(TugasAkhir $tugasAkhir)
    {
        
    }

}
