<?php

namespace App\Http\Controllers\Administrator\Jadwal;

use App\Models\PeriodeTa;
use App\Models\BimbingUji;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\JadwalSeminar;
use App\Models\Revisi;
use Exception;

class JadwalController extends Controller
{
    public function index($jenis = 'pembimbing')
    {
        $user = getInfoLogin()->userable;
        $periode = PeriodeTa::where('is_active', 1)->first();
        $query = [];
        if(getInfoLogin()->hasRole('Dosen')) {
            $query = BimbingUji::where('dosen_id', $user->id)->where('jenis', $jenis)->whereHas('tugas_akhir', function($q) use ($periode) {
                $q->where('periode_ta_id', $periode->id);
            })->get();
        }
        $data = [
            'title' => 'Jadwal',
            'mods' => 'jadwal',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Jadwal',
                    'is_active' => true
                ]
            ],
            'data' => $query,
        ];
        return view('administrator.jadwal.index', $data);
    }

    public function rating(JadwalSeminar $jadwal)
    {
        $data = [
            'title' => 'Jadwal Seminar',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard'),
                ],
                [
                    'title' => 'Tugas Akhir',
                    'is_active' => true,
                ],
                [
                    'title' => 'Jadwal Seminar',
                    'is_active' => true,
                ],
                [
                    'title' => 'Detail Penilaian',
                    'is_active' => true
                ]
            ],
            'data' => $jadwal
        ];
        
        return view('administrator.jadwal.nilai', $data);
    }

    public function revisi(Request $request, JadwalSeminar $jadwal)
    {
        $request->validate([
            'revisi' => 'required'
        ]);
        
        try {
            // get penguji
            $bimbingUji = $jadwal->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first();

            // check revisi
            $check = Revisi::where('bimbing_uji_id', $bimbingUji->id)->where('type', 'Seminar');

            if($check->count() > 0) {
                $check->update(['catatan' => $request->revisi]);
            } else {
                // insert revision
                Revisi::create([
                    'bimbing_uji_id' => $bimbingUji->id,
                    'type' => 'Seminar',
                    'catatan' => $request->reisi,
                ]);
            }

            return redirect()->back()->with(['success' => 'Revisi berhasil disimpan']);
        } catch(Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
}
