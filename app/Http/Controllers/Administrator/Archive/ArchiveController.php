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
        $periode = PeriodeTa::whereIsActive(true)->get();
        $query = TugasAkhir::with(['mahasiswa','periode_ta'])->whereStatus('acc')->whereIn('periode_ta_id', $periode->pluck('id'))->whereNotNull('status_sidang')->where('status_pemberkasan','sudah_lengkap');

        if($request->has('program_studi') && !empty($request->program_studi) && $request->program_studi != 'semua') {
            $query->whereHas('mahasiswa', function($q) use ($request) {
                $q->where('program_studi_id', $request->program_studi);
            });
        }

        if($request->has('periode') && !empty($request->periode) && $request->periode != 'semua') {
            $query->where('program_studi_id', $request->program_studi);

        }
        $query = $query->get();

        if($request->has('program_studi') && !empty($request->program_studi) && $request->program_studi != 'semua') {
            $periode = PeriodeTa::whereProgramStudiId($request->program_studi)->get();
        } else {
            $periode = PeriodeTa::all();
        }

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
            'data' => $query,
            'prodi' => ProgramStudi::all(),
            'periode' => $periode,
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

    public function backupDatabase()
    {
        $database = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $host     = env('DB_HOST', '127.0.0.1');
        $port     = env('DB_PORT', '3306');

        // Generate filename with timestamp
        $filename = "Database_{$database}_backup_" . now()->format('Y-m-d_H-i-s') . ".sql";

        // Construct mysqldump command with compression
        $command = "mysqldump --user={$username} --password=\"{$password}\" --host={$host} --port={$port} {$database}";

        // Execute the command and capture the output
        $result = null;
        $output = null;
        exec($command, $output, $result);

        // Check if backup was successful
        if ($result !== 0) {
            return response()->json(['status' => 'error', 'message' => 'Database backup failed.'], 500);
        }

        return response()->streamDownload(function () use ($command) {
            passthru($command);
        }, $filename, [
            'Content-Type' => 'application/sql',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
