<?php

namespace App\Http\Controllers\Administrator\Jadwal;

use App\Models\PeriodeTa;
use App\Models\BimbingUji;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\JadwalSeminar;
use App\Models\KategoriNilai;
use App\Models\Penilaian;
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
                    'title' => 'Jadwal Seminar',
                    'is_active' => true
                ]
            ],
            'data' => $query,
        ];
        return view('administrator.jadwal.index', $data);
    }

    public function evaluation(JadwalSeminar $jadwal)
    {
        $recapPemb1 = $jadwal->tugas_akhir->bimbing_uji()->where('jenis', 'pembimbing')->where('urut', 1)->first()->penilaian()->where('type', 'Seminar')->sum('nilai');
        $recapPemb1 = $recapPemb1 > 0 ? $recapPemb1 / $jadwal->tugas_akhir->bimbing_uji()->where('jenis', 'pembimbing')->where('urut', 1)->first()->penilaian()->where('type', 'Seminar')->count() : 0;
        $recapPemb2 = $jadwal->tugas_akhir->bimbing_uji()->where('jenis', 'pembimbing')->where('urut', 2)->first()->penilaian()->where('type', 'Seminar')->sum('nilai');
        $recapPemb2 = $recapPemb2 > 0 ? $recapPemb2 / $jadwal->tugas_akhir->bimbing_uji()->where('jenis', 'pembimbing')->where('urut', 2)->first()->penilaian()->where('type', 'Seminar')->count() : 0;
        $recapPenguji1 = $jadwal->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', 1)->first()->penilaian()->where('type', 'Seminar')->sum('nilai');
        $recapPenguji1 = $recapPenguji1 > 0 ? $recapPenguji1 / $jadwal->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', 1)->first()->penilaian()->where('type', 'Seminar')->count() : 0;
        $recapPenguji2 = $jadwal->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', 2)->first()->penilaian()->where('type', 'Seminar')->sum('nilai');
        $recapPenguji2 = $recapPenguji2 > 0 ? $recapPenguji2 / $jadwal->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', 2)->first()->penilaian()->where('type', 'Seminar')->count() : 0;

        $data = [
            'title' => 'Jadwal Seminar',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard'),
                ],
                [
                    'title' => 'Jadwal Seminar',
                    'url' => route('apps.jadwal', strtolower($jadwal->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->jenis))
                ],
                [
                    'title' => 'Detail',
                    'is_active' => true
                ]
            ],
            'data' => $jadwal,
            'kategoriNilais' => KategoriNilai::all(),
            'nilais' => $jadwal->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->penilaian()->where('type', 'Seminar')->get(),
            'recapPemb1' => $recapPemb1,
            'recapPemb2' => $recapPemb2,
            'recapPenguji1' => $recapPenguji1,
            'recapPenguji2' => $recapPenguji2
        ];
        
        return view('administrator.jadwal.penilaian', $data);
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
                    'catatan' => $request->revisi,
                ]);
            }

            return redirect()->back()->with(['success' => 'Revisi berhasil disimpan']);
        } catch(Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function nilai(Request $request, JadwalSeminar $jadwal)
    {
        try {
            $categories = KategoriNilai::all();
            $ratings = [];

            foreach($categories as $category) {
                $request->validate([
                    'nilai_'.$category->id => 'required'
                ]);

                // check if exist
                $check = $jadwal->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->penilaian()->where('kategori_nilai_id', $category->id)->where('type', 'Seminar')->first();

                if($check) {
                    $check->update([
                        'rating' => $request->input('nilai_'.$category->id)
                    ]);
                } else {
                    $ratings[] = [
                        'bimbing_uji_id' => $jadwal->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->id,
                        'kategori_nilai_id' => $category->id,
                        'nilai' => $request->input('nilai_'.$category->id),
                        'type' => 'Seminar',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            if(count($ratings) > 0) {
                Penilaian::insert($ratings);
            }

            return redirect()->back()->with(['success' => 'Nilai berhasil disimpan']);
        } catch(Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function cetakRevisi(JadwalSeminar $jadwal) 
    {
        $jdwl = JadwalSeminar::with(['tugas_akhir.bimbing_uji.revisi.bimbingUji.dosen','tugas_akhir.bimbing_uji.revisi.bimbingUji.tugas_akhir.mahasiswa'])->findOrFail($jadwal->id);
        $allRevisis = $jdwl->tugas_akhir->bimbing_uji->flatMap(function ($bimbingUji) {
            if ($bimbingUji->revisi->isEmpty()) {
                return [];
            }
            return $bimbingUji->revisi->map(function ($revisi) use ($bimbingUji) {
                return [
                    'revisi' => $revisi,
                    'dosen' => $bimbingUji->dosen,
                ];
            });
        })->toArray();
        $bu = $jadwal->tugas_akhir->bimbing_uji()->where('jenis','pembimbing')->orderBy('urut', 'asc')->get();
        $data = [
            'title' => 'Lembar Revisi',
            'jadwal' => $jdwl,
            'rvs' => $allRevisis,
            'bimbingUji' => $bu,
        ];

        return view('administrator.template.revisi', $data);
    }
}
