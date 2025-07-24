<?php

namespace App\Http\Controllers\Administrator\Archive;

use ZipArchive;
use ZipStream\ZipStream;
use App\Models\PeriodeTa;
use App\Models\TugasAkhir;
use App\Models\JenisDokumen;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use ZipStream\Option\Archive;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ArchiveController extends Controller
{
   public function index(Request $request)
    {
        // Ambil semua periode aktif
        $activePeriodes = PeriodeTa::where('is_active', true)->get();
        $activePeriodeIds = $activePeriodes->pluck('id');

        // Cek apakah user memilih filter periode atau tidak
        $selectedPeriodeId = $request->has('periode') && !empty($request->periode) && $request->periode != 'semua'
            ? $request->periode
            : ($activePeriodeIds->count() > 0 ? $activePeriodeIds : []); // default gunakan periode aktif

        // Mulai query
        $query = TugasAkhir::with(['mahasiswa', 'periode_ta'])
            ->where('status', 'acc')
            ->where('status_pemberkasan_sidang', 'sudah_lengkap');

        // Filter periode (pakai dari filter user atau default aktif)
        if (!empty($selectedPeriodeId)) {
            $query->whereIn('periode_ta_id', is_array($selectedPeriodeId) ? $selectedPeriodeId : [$selectedPeriodeId]);
        }

        // Filter program studi jika dipilih
        if ($request->has('program_studi') && !empty($request->program_studi) && $request->program_studi != 'semua') {
            $query->whereHas('mahasiswa', function ($q) use ($request) {
                $q->where('program_studi_id', $request->program_studi);
            });
        }

        // Ambil data
        $dataTugasAkhir = $query->get();

        // Ambil data periode untuk select option di view
        $listPeriode = $request->has('program_studi') && !empty($request->program_studi) && $request->program_studi != 'semua'
            ? PeriodeTa::where('program_studi_id', $request->program_studi)->get()
            : PeriodeTa::all();

        // Siapkan data untuk dikirim ke view
        $data = [
            'title' => 'Arsip',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Arsip',
                    'is_active' => true
                ],
            ],
            'data' => $dataTugasAkhir,
            'prodi' => ProgramStudi::all(),
            'periode' => $listPeriode,
            'selected_periode' => $selectedPeriodeId,
        ];

        return view('administrator.archive.index', $data);
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
