<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\JadwalSeminar;
use App\Models\TugasAkhir;
use App\Models\PeriodeTa;
use App\Models\BimbingUji;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Mengatur locale ke bahasa Indonesia
        setlocale(LC_TIME, 'id_ID.UTF-8', 'Indonesian_indonesia.1252');
        $periode = PeriodeTa::where('is_active', 1)->first();
        $user = Auth::guard('web')->user();
        $roles = $user->getRoleNames();

        if(session('switchRoles') == 'admin'){
            $dosen = Dosen::count();
            $mahasiswa = Mahasiswa::count();
            $user = User::count();
            $hari_ini = date('Y-m-d');
            $jadwal = JadwalSeminar::with(['tugas_akhir'])->whereHas('tugas_akhir', function($q)use($periode){
                $q->where('periode_ta_id', $periode->id);
            })->where('tanggal', $hari_ini)->count();


            $jadwalSeminar = JadwalSeminar::with(['tugas_akhir'])->whereHas('tugas_akhir', function($q)use($periode){
                $q->where('periode_ta_id', $periode->id);
            });
            $totalJadwalSem = $jadwalSeminar->count();
            $totalTelahSem = $jadwalSeminar->where('status', 1)->count();
            

            $dapatDospem = BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'pembimbing')->where('urut', 2)->whereHas('tugas_akhir', function ($q) use($periode){
                $q->where('periode_ta_id', $periode->id);
            })->count();


            return view('dashboard.index', [
                "title" => "Dashboard",
                "breadcrumb1" => "Dashboard",
                "breadcrumb2" => "Index",
                "totalDosen" => $dosen,
                "totalMahasiswa" => $mahasiswa,
                "totalUser" => $user,
                "totalJadwal" => $jadwal,
                "totalDapatDospem" => $dapatDospem,
                "totalJadwalSem" => $totalJadwalSem,
                "totalTelahSem" => $totalTelahSem,
                "totalPengajuan" => TugasAkhir::where('periode_ta_id', $periode->id)->count(),
                "totalACC"=> TugasAkhir::where('periode_ta_id', $periode->id)->where('status', 'acc')->count(),
                'jsInit' => 'js_dashboard_admin.js',
                'dataChart' => [
                    ["nilai" => $jadwal, 'label' => 'Seminar Hari Ini'],
                    ["nilai" => $dapatDospem, 'label' => 'Mendapat Dospem'],
                    ["nilai" => $totalJadwalSem, 'label' => 'Terjadwalkan'],
                    ["nilai" => $totalTelahSem, 'label' => 'Telah Diseminarkan'],
                    ["nilai" => TugasAkhir::where('periode_ta_id', $periode->id)->count(), 'label' => 'Pengajuan'],
                    ["nilai"=> TugasAkhir::where('periode_ta_id', $periode->id)->where('status', 'acc')->count(), 'label' => 'Di ACC'],
                ],
                
            ]);
        }else if(session('switchRoles') == 'kaprodi'){
            $jadwalSeminar = JadwalSeminar::with(['tugas_akhir'])->whereHas('tugas_akhir', function($q)use($periode){
                $q->where('periode_ta_id', $periode->id);
            });
            $totalJadwalSem = $jadwalSeminar->count();

            return view('dashboard.index-kaprodi', [
                "title" => "Dashboard",
                "breadcrumb1" => "Dashboard",
                "breadcrumb2" => "Index",
                "totalPengajuan" => TugasAkhir::where('periode_ta_id', $periode->id)->count(),
                "totalACC"=> TugasAkhir::where('periode_ta_id', $periode->id)->where('status', 'acc')->count(),
                "totalReject"=> TugasAkhir::where('periode_ta_id', $periode->id)->where('status', 'reject')->count(),
                'jsInit' => 'js_dashboard_kaprodi.js',
                'dataChart' => [
                    ["nilai" => TugasAkhir::where('periode_ta_id', $periode->id)->count(), 'label' => 'Pengajuan'],
                    ["nilai"=> TugasAkhir::where('periode_ta_id', $periode->id)->where('status', 'acc')->count(), 'label' => 'Di ACC'],
                    ["nilai"=> TugasAkhir::where('periode_ta_id', $periode->id)->where('status', 'reject')->count(), 'label' => 'Di Reject'],
                ],
                
            ]);
        }else if(session('switchRoles') == 'dosen'){
            $mahasiswa = BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'pembimbing')->whereHas('tugas_akhir', function($q)use($periode){
                $q->where('periode_ta_id', $periode->id);
            })->whereHas('dosen', function($q)use($user){
                $q->where('user_id', $user->id);
            })->count();
            $mahasiswaUji = BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'penguji')->whereHas('tugas_akhir', function($q)use($periode){
                $q->where('periode_ta_id', $periode->id);
            })->whereHas('dosen', function($q)use($user){
                $q->where('user_id', $user->id);
            })->count();
            $totalTelahSem = BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'penguji')->whereHas('tugas_akhir', function($q)use($periode){
                $q->where('periode_ta_id', $periode->id)->whereNotNull('status_seminar');
            })->whereHas('dosen', function($q)use($user){
                $q->where('user_id', $user->id);
            })->count();

            // dd($mahasiswa);
            return view('dashboard.index-dosen', [
                "title" => "Dashboard",
                "breadcrumb1" => "Dashboard",
                "breadcrumb2" => "Index",
                "mahasiswa" => $mahasiswa,
                "mahasiswaUji" => $mahasiswaUji,
                "telahSidang" => $totalTelahSem,
                'jsInit' => 'js_dashboard_dosen.js',
                'dataChart' => [
                    ["nilai" => $mahasiswa, 'label' => 'Mahasiswa Bimbingan'],
                    ["nilai"=> $mahasiswaUji, 'label' => 'Mahasiswa Uji'],
                    ["nilai"=> $totalTelahSem, 'label' => 'Telah Seminar'],
                ],
            ]);
        }else if(session('switchRoles') == 'mahasiswa'){
            $mh = Mahasiswa::where('user_id', $user->id)->first();
            $jadwalSeminar = JadwalSeminar::with(['tugas_akhir'])
            ->whereHas('tugas_akhir', function($q)use($periode, $mh){
                $q->where('periode_ta_id', $periode->id)->where('mahasiswa_id', $mh->id);
            });
            $jadwalSeminar = $jadwalSeminar->get();
            $ta = TugasAkhir::with(['mahasiswa', 'topik', 'jenis_ta'])->whereHas('mahasiswa', function($q)use($user){
                $q->where('user_id', $user->id);
            });
            $tta = $ta->where('status', 'acc')->get();
            // Membuat objek DateTime untuk tanggal sekarang
            $tanggal = $jadwalSeminar[0]->tanggal ?? date('Y-m-d');
            // Format tanggal dalam bahasa Indonesia
            $tanggalFormatted = strftime('%A, %d %B %Y', strtotime($tanggal));

            // dd($tanggalFormatted);
            return view('dashboard.index-mahasiswa', [
                "title" => "Dashboard",
                "breadcrumb1" => "Dashboard",
                "breadcrumb2" => "Index",
                "statusTa" => $tta[0]->status ?? 'belum',
                "jadwalSeminar" => $tanggalFormatted,
                "jam_mulai" => $jadwalSeminar[0]->jam_mulai ?? 0,
                "jam_selesai" => $jadwalSeminar[0]->jam_selesai ?? 0,
                "data_dosen" => Dosen::with(['rumpun_ilmu'])->get(),
                
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function switching()
    {
        //
        $user = Auth::guard('web')->user();
        $roles = $user->getRoleNames();

        // dd($roles);
        return view('dashboard.switching', [
            "title" => "Switch",
            "breadcrumb1" => "Switch",
            "breadcrumb2" => "Index",
            'data'   => $roles,
        ]);
    }

    public function switcher(Request $request)
    {
        // dd($request->role);
        session(['switchRoles' => $request->role]);
        return redirect()->route('admin.dashboard');
    }
    public function monitoring(){
        $periode = PeriodeTa::where('is_active', 1)->first();
        
        // Mengambil data jadwal seminar
        $d = JadwalSeminar::with(['tugas_akhir', 'ruangan'])
            ->whereHas('tugas_akhir', function($q) use ($periode) {
                $q->where('periode_ta_id', $periode->id);
            })
            ->get();
        
        // Memformat data untuk kalender
        $ar = $d->map(function ($item) {
            return [
                'title' => $item->tugas_akhir->judul,
                'start' => $item->tanggal, // Pastikan format tanggal sesuai
                // 'end' => $item->end_date ? $item->end_date->format('Y-m-d') : null, // Jika ada tanggal akhir
            ];
        });
    
        return view('dashboard.monitoring', [
            "title" => "Monitoring",
            "breadcrumb1" => "Monitoring",
            "breadcrumb2" => "Index",
            "data" => $ar, // Mengirim data langsung, akan di-handle di Blade
        ]);
    }
    

}
