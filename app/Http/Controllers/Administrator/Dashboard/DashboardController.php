<?php

namespace App\Http\Controllers\Administrator\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\JadwalSeminar;
use App\Models\Mahasiswa;
use App\Models\PeriodeTa;
use App\Models\ProgramStudi;
use App\Models\Sidang;
use App\Models\TugasAkhir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $dataRole = [];

        if (session('switchRoles') == 'Admin') {
            $dataRole = $this->adminRole();
        }

        $data = [
            'title' => 'Dashboard',
        ];

        return view('administrator.dashboard.index', array_merge($data, $dataRole));
    }

    public function getGraduatedData(Request $request)
    {
        $data = TugasAkhir::select(DB::raw('count(*) as count'), 'periode_tas.id')->join('periode_tas', 'tugas_akhirs.periode_ta_id', '=', 'periode_tas.id')->where('status', 'acc')->whereNotNull('status_sidang')->where('status_pemberkasan', 'sudah_lengkap')->groupBy('periode_ta_id')->get();
        $periode = PeriodeTa::limit(8)->get();

        $data = $periode->map(function ($item) use ($data) {
            return (object) [
                'name' => $item->nama,
                'prodi' => $item->programStudi->nama,
                'count' => $data->where('id', $item->id)->first() ? $data->where('id', $item->id)->first()->count : 0
            ];
        });

        $programStudies = ProgramStudi::all();
        $categories = array_values(array_unique($data->map(function ($item) {
            return $item->name;
        })->toArray()));

        return response()->json([
            'message' => 'success',
            'categories' => $categories,
            'series' => $programStudies->map(function ($prodi) use ($data, $categories) {
                return [
                    'name' => $prodi->nama,
                    'data' => $data->where('prodi', $prodi->nama)->map(function ($item) use ($prodi) {
                        return $item->count;
                    })->take(count($categories))->pad(count($categories), 0)->values()
                ];
            }),
        ]);
    }

    public function getStudentData(Request $request)
    {
        $data = Mahasiswa::select(DB::raw('count(*) as count'), 'program_studis.id')->join('program_studis', 'mahasiswas.program_studi_id', '=', 'program_studis.id')->groupBy('program_studis.id')->get();
        $programStudies = ProgramStudi::all();

        return response()->json([
            'message' => 'success',
            'labels' => $programStudies->pluck('nama')->toArray(),
            'series' => $programStudies->map(function ($prodi) use ($data, $programStudies) {
                return $data->where('id', $prodi->id)->first() ? $data->where('id', $prodi->id)->first()->count : 0;
            }),
        ]);
    }

    public function getScheduleData(Request $request)
    {
        // get periode active
        $periode = PeriodeTa::whereIsActive(true)->get();

        // set default type
        $type = $request->has('type') ? $request->type : 'seminar';
        $date = $request->has('date') ? $request->date : date('Y-m-d');

        // type is semiar, get data seminar
        $dataSeminar = JadwalSeminar::whereDate('tanggal', $date)->whereHas('tugas_akhir', function($q) use ($periode) {
            $q->whereIn('periode_ta_id', $periode->pluck('id')->toArray());
        })->where('status', 'sudah_terjadwal')->with(['tugas_akhir', 'tugas_akhir.mahasiswa', 'tugas_akhir.mahasiswa.user', 'tugas_akhir.mahasiswa.programStudi', 'tugas_akhir.bimbing_uji', 'tugas_akhir.bimbing_uji.dosen', 'ruangan'])->get();
        // if ($type == 'seminar') {
        // } else {
        // }
        $dataSidang = Sidang::whereDate('tanggal', $date)-> whereHas('tugas_akhir', function($q) use ($periode) {
            $q->whereIn('periode_ta_id', $periode->pluck('id')->toArray());
        })->where('status', 'sudah_terjadwal')->with(['tugas_akhir', 'tugas_akhir.mahasiswa', 'tugas_akhir.mahasiswa.user', 'tugas_akhir.mahasiswa.programStudi', 'tugas_akhir.bimbing_uji', 'tugas_akhir.bimbing_uji.dosen', 'ruangan'])->get();

        // set type seminar
        $dataSeminar = $dataSeminar->map(function ($item) {
            $item->type = "seminar";
            return $item;
        });

        // set type sidang
        $dataSidang = $dataSidang->map(function ($item) {
            $item->type = "sidang";
            return $item;
        });

        // merge and return data
        return response()->json([
            'message' => 'success',
            'data' => collect(array_merge($dataSeminar->toArray(), $dataSidang->toArray()))->sortBy('tanggal', SORT_REGULAR, false)->sortBy('jam_mulai')->values(),
        ]);
    }

    private function adminRole(): array
    {
        $data = [
            'dosenCount' => Dosen::all()->count(),
            'mhsCount' => Mahasiswa::all()->count(),
            'taCount' => TugasAkhir::all()->count(),
            'topikCount' => TugasAkhir::whereStatus('draft')->count(),
            'mhsBelumSeminarCount' => TugasAkhir::where('status', 'acc')->whereNull(['status_seminar', 'status_sidang'])->count(),
            'mhsSudahSeminarCount' => TugasAkhir::where('status', 'acc')->whereNotNull('status_seminar')->count(),
            'mhsBelumSidangCount' => TugasAkhir::where('status', 'acc')->whereNull('status_sidang')->count(),
            'mhsSudahSidangCount' => TugasAkhir::where('status', 'acc')->whereNotNull('status_sidang')->count(),
            'mods' => 'dashboard_admin'
        ];

        return $data;
    }
}
