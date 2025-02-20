<?php

namespace App\Http\Controllers\Administrator\Dashboard;

use App\Models\Dosen;
use App\Models\Sidang;
use App\Models\Mahasiswa;
use App\Models\PeriodeTa;
use App\Models\BimbingUji;
use App\Models\KuotaDosen;
use App\Models\TugasAkhir;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Models\JadwalSeminar;
use App\Models\RekomendasiTopik;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $dataRole = [];

        if (in_array(session('switchRoles'), ['Admin','Developer','Teknisi'])) {
            $dataRole = $this->adminRole();
            dd($dataRole);
        }

        if (session('switchRoles') == 'Mahasiswa') {
            $dataRole = $this->mahasiswaRole();
        }

        if (session('switchRoles') == 'Dosen') {
            $dataRole = $this->dosenRole();
        }

        if (session('switchRoles') == 'Kaprodi') {
            $dataRole = $this->kaprodiRole();
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
        })->where('status', 'sudah_terjadwal')->with(['tugas_akhir', 'tugas_akhir.mahasiswa', 'tugas_akhir.mahasiswa.user', 'tugas_akhir.mahasiswa.programStudi', 'tugas_akhir.bimbing_uji', 'tugas_akhir.bimbing_uji.dosen', 'ruangan']);
        // if ($type == 'seminar') {
        // } else {
        // }
        $dataSidang = Sidang::whereDate('tanggal', $date)-> whereHas('tugas_akhir', function($q) use ($periode) {
            $q->whereIn('periode_ta_id', $periode->pluck('id')->toArray());
        })->where('status', 'sudah_terjadwal')->with(['tugas_akhir', 'tugas_akhir.mahasiswa', 'tugas_akhir.mahasiswa.user', 'tugas_akhir.mahasiswa.programStudi', 'tugas_akhir.bimbing_uji', 'tugas_akhir.bimbing_uji.dosen', 'ruangan']);

        if (session('switchRoles') == 'Dosen') {
            $dataSeminar->whereHas('tugas_akhir.bimbing_uji', function ($q) {
                $q->where('dosen_id', getinfologin()->userable->id);
            });
    
            $dataSidang->whereHas('tugas_akhir.bimbing_uji', function ($q) {
                $q->where('dosen_id', getinfologin()->userable->id);
            });
        }

        if (session('switchRoles') == 'Kaprodi') {
            $dataSeminar->whereHas('tugas_akhir.mahasiswa', function ($q) {
                $q->where('program_studi_id', getInfoLogin()->userable->program_studi_id);
            });
    
            $dataSidang->whereHas('tugas_akhir.mahasiswa', function ($q) {
                $q->where('program_studi_id', getInfoLogin()->userable->program_studi_id);
            });
        }

        $dataSeminar = $dataSeminar->get();
        $dataSidang = $dataSidang->get();

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
            'totalTa' => TugasAkhir::whereIn('status', ['reject'])->count(),
            'mhsBelumDaftarTa' => Mahasiswa::whereDoesntHave('tugas_akhir')->count(),
            'mhsBelumSeminarCount' => TugasAkhir::where('status', 'acc')->whereNull(['status_seminar', 'status_sidang'])->count(),
            'mhsSudahSeminarCount' => TugasAkhir::where('status', 'acc')->whereNotNull('status_seminar')->count(),
            'mhsBelumSidangCount' => TugasAkhir::where('status', 'acc')->whereNull('status_sidang')->count(),
            'mhsSudahSidangCount' => TugasAkhir::where('status', 'acc')->whereNotNull('status_sidang')->count(),
            'mods' => ['dashboard_admin', 'dashboard'],
        ];

        return $data;
    }

    private function mahasiswaRole(): array
    {
        $tugasAkhir = TugasAkhir::where('mahasiswa_id', getInfoLogin()->userable->id)->orderBy('id', 'desc')->first();
        $data = [
            'tugasAkhir' => $tugasAkhir,
            'mods' => 'dashboard',
        ];

        return $data;
    }

    private function dosenRole(): array
    {
        $user = getInfoLogin()->userable;
        $bimbing = BimbingUji::where('dosen_id', $user->id)->where('jenis', 'pembimbing');
        $uji = BimbingUji::where('dosen_id', $user->id)->where('jenis', 'penguji');
        $periode = PeriodeTa::where('is_active', 1)->get();
        $kuota = KuotaDosen::whereIn('periode_ta_id', $periode->pluck('id'))->where('dosen_id', $user->id)->get();
        $totalKuota = $kuota->sum('pembimbing_1');
        $bimbingUji = BimbingUji::whereHas('tugas_akhir', function ($query) use ($periode) {
            $query->whereNotIn('status',['reject', 'cancel'])->whereIn('periode_ta_id', $periode->pluck('id'));
        })->where('dosen_id', $user->id)->where('jenis', 'pembimbing')->where('urut', 1)->count();
        $sisaKuota = $totalKuota - $bimbingUji;
        $data = [
            'mods' => 'dashboard',
            'bimbing' => $bimbing,
            'uji' => $uji,
            'kuota' => $kuota,
            'sisaKuota' => $sisaKuota,
        ];

        return $data;
    }

    private function kaprodiRole(): array
    {
        $user = getInfoLogin()->userable;
        $prodi = $user->programStudi->id;
        $belumAcc = RekomendasiTopik::where('status','Menunggu')->where('program_studi_id', $prodi)->get();
        $sudahAcc = RekomendasiTopik::where('status','Disetujui')->where('program_studi_id', $prodi)->get();
        $taDraft = TugasAkhir::whereIn('status',['draft','pengajuan ulang'])->whereHas('mahasiswa', function($query) use ($prodi) {
            $query->where('program_studi_id', $prodi);
        })->get();
        $taAcc = TugasAkhir::where('status','acc')->whereHas('mahasiswa', function($query) use ($prodi) {
            $query->where('program_studi_id', $prodi);
        })->get();
        
        $data = [
            'mods' => 'dashboard',
            'belumAcc' => $belumAcc,
            'sudahAcc' => $sudahAcc,
            'taDraft' => $taDraft,
            'taAcc' => $taAcc
        ];

        return $data;
    }


    public function exportJadwal()
    {

        return Excel::download(new JadwalExport(), "Jadwal.xlsx");
    }
}
