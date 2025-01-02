<?php

namespace App\Http\Controllers\Administrator\DaftarBimbingan;

use App\Models\PeriodeTa;
use App\Models\BimbingUji;
use App\Models\KuotaDosen;
use App\Models\JenisDokumen;
use App\Models\ProgramStudi;
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

        if ($request->has('program_studi') && !empty($request->program_studi) && $request->program_studi !== 'semua') {
            $query->whereHas('tugas_akhir.mahasiswa', function($query) use ($request) {
                $query->whereProgramStudiId($request->program_studi);
            });
        }

        if ($request->status == 'mahasiswa_uji') {
            $query->whereIn('jenis', ['penguji','pengganti']);
        } else {
            $query->where('jenis', 'pembimbing');
        }

        if ($request->status == 'mahasiswa_uji') {
            $query->whereIn('jenis', ['penguji', 'pengganti']);
            
            if ($request->has('penguji') && $request->penguji !== 'semua') {
                $query->where('urut', $request->penguji);
            }
        } else {
            $query->where('jenis', 'pembimbing');
            
            if ($request->has('pembimbing') && $request->pembimbing !== 'semua') {
                $query->where('urut', $request->pembimbing);
            }
        }
        
        $query = $query->get();
        $kuota = KuotaDosen::whereIn('periode_ta_id', $periode->pluck('id'))->where('dosen_id', $user->id)->with('programStudi')->get();
        $bimbing1 = BimbingUji::where('dosen_id', $user->id)->where('jenis', 'pembimbing')->where('urut', 1)->whereHas('tugas_akhir', function ($query) {
                $query->whereNotIn('status', ['reject', 'cancel']);
            })->with(['tugas_akhir.mahasiswa.programStudi'])->get()->groupBy('tugas_akhir.mahasiswa.program_studi_id')->map(function ($group) {
                return $group->count();
            });
        
        $bimbing2 = BimbingUji::where('dosen_id', $user->id)->where('jenis', 'pembimbing')->where('urut', 2)->whereHas('tugas_akhir', function ($query) {
                $query->whereNotIn('status', ['reject', 'cancel']);
            })->with(['tugas_akhir.mahasiswa.programStudi'])->get()->groupBy('tugas_akhir.mahasiswa.program_studi_id')->map(function ($group) {
                return $group->count();
            });
        
        $sisaKuota = $kuota->map(function ($item) use ($bimbing1, $bimbing2) {
            $programStudiId = $item->program_studi_id;
        
            $mahasiswaBimbing1 = $bimbing1->get($programStudiId, 0);
            $mahasiswaBimbing2 = $bimbing2->get($programStudiId, 0);
        
            return [
                'prodi' => $item->programStudi->display ?? 'Tidak Diketahui',
                'total_kuota_pemb_1' => $item->pembimbing_1 ?? 0,
                'sisa_kuota_pemb_1' => max(($item->pembimbing_1 ?? 0) - $mahasiswaBimbing1, 0),
                'total_kuota_pemb_2' => $item->pembimbing_2 ?? 0,
                'sisa_kuota_pemb_2' => max(($item->pembimbing_2 ?? 0) - $mahasiswaBimbing2, 0),
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
            'bimbing1' => $bimbing1,
            'bimbing2' => $bimbing2,
            'prodi' => ProgramStudi::all(),
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
