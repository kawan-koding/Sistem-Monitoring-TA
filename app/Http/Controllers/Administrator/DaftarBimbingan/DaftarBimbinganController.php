<?php

namespace App\Http\Controllers\Administrator\DaftarBimbingan;

use App\Models\PeriodeTa;
use App\Models\BimbingUji;
use App\Models\KuotaDosen;
use App\Models\JenisDokumen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DaftarBimbinganController extends Controller
{
    public function index(Request $request)
    {
        $query = [];
        $user = getInfoLogin()->userable;
        $periode = PeriodeTa::where('is_active', 1)->get();
        $query = BimbingUji::with(['tugas_akhir', 'dosen'])->where('dosen_id', $user->id)->whereHas('tugas_akhir', function($q) use ($periode){
            $q->whereIn('periode_ta_id', $periode->pluck('id'));
        });
        if ($request->status == 'mahasiswa_uji') {
            $query->where('jenis', 'penguji');
        } else {
            $query->where('jenis', 'pembimbing');
        }
        $query = $query->get();
        $kuota = KuotaDosen::whereIn('periode_ta_id', $periode->pluck('id'))->where('dosen_id', $user->id)->with('programStudi')->get();
        $bimbing = BimbingUji::where('dosen_id', $user->id)->where('jenis', 'pembimbing')->where('urut', 1)->whereHas('tugas_akhir', function ($query) {
            $query->whereNotIn('status', ['reject', 'cancel']);
        })->with(['tugas_akhir.mahasiswa.programStudi'])->get()->groupBy('tugas_akhir.mahasiswa.program_studi_id')->map(function ($group) {
            return $group->count();
        });
        
        $sisaKuota = $kuota->map(function ($item) use ($bimbing) {
            $programStudiId = $item->program_studi_id;
            $mahasiswaBimbing = $bimbing->get($programStudiId, 0);
            return [
                'prodi' => $item->programStudi->display ?? 'Tidak Diketahui',
                'total_kuota' => $item->pembimbing_1 ?? 0,
                'sisa_kuota' => max($item->pembimbing_1 - $mahasiswaBimbing, 0),
            ];
        });
        

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
            'kuota' => $kuota,
            'sisaKuota' => $sisaKuota,
            'bimbing' => $bimbing,
        ];
        
        return view('administrator.daftar-bimbingan.index', $data);
    }

    public function show(BimbingUji $bimbingUji)
    {
        $query = $bimbingUji->tugas_akhir;
        $bimbingUji = $query->bimbing_uji;
        $pembimbing1 = $bimbingUji->where('jenis', 'pembimbing')->where('urut', 1)->first();
        $pembimbing2 = $bimbingUji->where('jenis', 'pembimbing')->where('urut', 2)->first();
        $penguji1 = $bimbingUji->where('jenis', 'penguji')->where('urut', 1)->first();
        $penguji2 = $bimbingUji->where('jenis', 'penguji')->where('urut', 2)->first();
        $docPengajuan = JenisDokumen::all();

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
            'dataTA' => $query,
            'pembimbingPenguji' => $bimbingUji,
            'pembimbing1' => $pembimbing1,
            'pembimbing2' => $pembimbing2,
            'penguji1' => $penguji1,
            'penguji2' => $penguji2,
            'doc' => $docPengajuan,
        ];

        return view('administrator.pengajuan-ta.partials.detail', $data);
    }
}
