<?php

namespace App\Http\Controllers\Administrator\Archive;

use App\Models\PeriodeTa;
use App\Models\TugasAkhir;
use App\Models\JenisDokumen;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Dosen;
use Illuminate\Support\Facades\Auth;

class ArchiveController extends Controller
{
    public function index(Request $request)
    {
        $activePeriodeIds = PeriodeTa::where('is_active', false)
            ->pluck('id')
            ->toArray();

        $selectedPeriodeId = $request->filled('periode') && $request->periode != 'semua'
            ? (array) $request->periode
            : $activePeriodeIds;

        $query = TugasAkhir::with(['mahasiswa', 'periode_ta'])
            ->where('status', 'acc')
            ->where('status_pemberkasan_sidang', 'sudah_lengkap');

        if (!empty($selectedPeriodeId)) {
            $query->whereIn('periode_ta_id', $selectedPeriodeId);
        }

        if ($request->filled('program_studi') && $request->program_studi != 'semua') {
            $query->whereHas('mahasiswa', function ($q) use ($request) {
                $q->where('program_studi_id', $request->program_studi);
            });
        }

        if ($request->filled('dosen') && $request->dosen != 'semua') {
            $query->whereHas('bimbing_uji', function ($q) use ($request) {
                $q->where('dosen_id', $request->dosen);
            });
        }

        $user = auth()->user();
        if ($request->filled('type') && $request->type == 'bimbing_uji') {
            if ($user->userable instanceof Dosen) {
                $dosenId = $user->userable->id;
                $query->whereHas('bimbing_uji', function ($q) use ($dosenId, $request) {
                    $q->where('dosen_id', $dosenId);
                     if ($request->filled('jenis') && $request->jenis != 'semua') {
                        $q->where('jenis', $request->jenis);
                    }
                });

            } else {
                $query->whereRaw('1 = 0');
            }
        }



        $dataTugasAkhir = $query->get();

        $listPeriode = $request->filled('program_studi') && $request->program_studi != 'semua'
            ? PeriodeTa::where('program_studi_id', $request->program_studi)->get()
            : PeriodeTa::all();

        return view('administrator.archive.index', [
            'title' => 'Arsip',
            'data' => $dataTugasAkhir,
            'prodi' => ProgramStudi::all(),
            'periode' => $listPeriode,
            'dosen' => Dosen::all(),
            'selected_periode' => $selectedPeriodeId,
        ]);
    }


    public function show(TugasAkhir $tugasAkhir)
    {
        $bimbingUji = $tugasAkhir->bimbing_uji;
        $pembimbing1 = $bimbingUji->where('jenis', 'pembimbing')->where('urut', 1)->first();
        $pembimbing2 = $bimbingUji->where('jenis', 'pembimbing')->where('urut', 2)->first();
        $penguji1 = $bimbingUji->where('jenis', 'penguji')->where('urut', 1)->first();
        $penguji2 = $bimbingUji->where('jenis', 'penguji')->where('urut', 2)->first();
        $docPengajuan = JenisDokumen::all();

        $data = [
            'title' => 'Detail Tugas Akhir',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Arsip',
                    'url' => route('apps.archives')
                ],
                [
                    'title' => 'Detail Tugas Akhir',
                    'is_active' => true
                ]
            ],
            'dataTA' => $tugasAkhir,
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
