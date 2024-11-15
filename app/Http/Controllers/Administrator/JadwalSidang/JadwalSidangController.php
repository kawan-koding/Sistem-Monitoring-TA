<?php

namespace App\Http\Controllers\Administrator\JadwalSidang;

use App\Models\Sidang;
use App\Models\Mahasiswa;
use App\Models\PeriodeTa;
use App\Models\JenisDokumen;
use Illuminate\Http\Request;
use App\Models\KategoriNilai;
use App\Http\Controllers\Controller;

class JadwalSidangController extends Controller
{
    public function index(Request $request)
    {
        $query = [];
        $periode = PeriodeTa::where('is_active', 1)->first();
        $query = Sidang::with(['tugas_akhir']);
        if(getInfoLogin()->hasRole('Mahasiswa')) {
            $myId = getInfoLogin()->userable;
            $mahasiswa = Mahasiswa::where('id', $myId->id)->first();
            if($mahasiswa) {
                $query->whereHas('tugas_akhir', function ($q) use($periode, $mahasiswa) {
                    $q->where('periode_ta_id', $periode->id)->where('mahasiswa_id', $mahasiswa->id);
                });
                $query = $query->get();
            }
        }

        if(getInfoLogin()->hasRole('Admin')) {
            if($request->has('tanggal') && !empty($request->tanggal)) {
                $query = $query->whereDate('tanggal', $request->tanggal);
            }

            if($request->has('status') && !empty($request->status)) {
                $query = $query->where('status', $request->status);
            } else {
                $query = $query->where('status', 'belum_daftar');
            }
            $query = $query->get();

            $query = $query->map(function($item) {
                $jenisDocument = JenisDokumen::whereIn('jenis', ['sidang', 'pra_sidang'])->count();
                $jenisDocumentComplete = JenisDokumen::whereIn('jenis', ['sidang', 'pra_sidang'])->whereHas('pemberkasan', function($q) use ($item) {
                    $q->where('tugas_akhir_id', $item->tugas_akhir->id);
                })->count();
                $item->document_complete = $jenisDocument - $jenisDocumentComplete == 0;
                return $item;
            });
        }

        $docSidang = JenisDokumen::whereIn('jenis', ['sidang', 'pra_sidang'])->get();
        $data = [
            'title' =>  'Jadwal Sidang',
            'mods' => 'jadwal_sidang',
            'breadcrumbs' =>[
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Jadwal Sidang',
                    'is_active' => true,
                ]
            ],
            'data' => $query,
            'status' => $request->has('status') ? $request->status : null,
            'document_sidang' => $docSidang,
        ];
        
        return view('administrator.jadwal-sidang.index', $data);
    }

    public function show(Sidang $sidang)
    {
        $recapPemb1 = $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'pembimbing')->where('urut', 1)->first()->penilaian()->where('type', 'Seminar')->sum('nilai');
        $recapPemb1 = $recapPemb1 > 0 ? $recapPemb1 / $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'pembimbing')->where('urut', 1)->first()->penilaian()->where('type', 'Seminar')->count() : 0;
        $recapPemb2 = $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'pembimbing')->where('urut', 2)->first()->penilaian()->where('type', 'Seminar')->sum('nilai');
        $recapPemb2 = $recapPemb2 > 0 ? $recapPemb2 / $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'pembimbing')->where('urut', 2)->first()->penilaian()->where('type', 'Seminar')->count() : 0;
        $recapPenguji1 = $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', 1)->first()->penilaian()->where('type', 'Seminar')->sum('nilai');
        $recapPenguji1 = $recapPenguji1 > 0 ? $recapPenguji1 / $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', 1)->first()->penilaian()->where('type', 'Seminar')->count() : 0;
        $recapPenguji2 = $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', 2)->first()->penilaian()->where('type', 'Seminar')->sum('nilai');
        $recapPenguji2 = $recapPenguji2 > 0 ? $recapPenguji2 / $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', 2)->first()->penilaian()->where('type', 'Seminar')->count() : 0;

        $data = [
            'title' => 'Jadwal Sidang',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard'),
                ],
                [
                    'title' => 'Jadwal Sidang',
                    'url' => route('apps.jadwal-sidang'),
                ],
                [
                    'title' => 'Detail',
                    'is_active' => true
                ]
            ],
            'data' => $sidang,
            'kategoriNilais' => KategoriNilai::all(),
            'bimbingUjis' => $sidang->tugas_akhir->bimbing_uji()->orderBy('jenis', 'desc')->orderBy('urut', 'asc')->get(),
            'recapPemb1' => $recapPemb1,
            'recapPemb2' => $recapPemb2,
            'recapPenguji1' => $recapPenguji1,
            'recapPenguji2' => $recapPenguji2
        ];

        return view('administrator.jadwal-sidang.detail', $data);

    }
}
