<?php

namespace App\Http\Controllers\Administrator\Jadwal;

use Exception;
use App\Models\Dosen;
use App\Models\Revisi;
use App\Models\Penilaian;
use App\Models\PeriodeTa;
use App\Models\BimbingUji;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Models\JadwalSeminar;
use App\Models\KategoriNilai;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class JadwalController extends Controller
{
    public function index(Request $request, $jenis = 'pembimbing')
    {
        $user = getInfoLogin()->userable;
        $periode = PeriodeTa::whereIsActive(true)->get();
        $query = [];
        if(getInfoLogin()->hasRole('Dosen')) {
            $query = BimbingUji::where('dosen_id', $user->id)->where('jenis', $jenis)->whereHas('tugas_akhir', function($q) use ($periode) {
                $q->whereIn('periode_ta_id', $periode->pluck('id'));
            });

            if ($request->has('program_studi') && !empty($request->program_studi) && $request->program_studi !== 'semua') {
                $query->whereHas('tugas_akhir.mahasiswa', function($query) use ($request) {
                    $query->whereProgramStudiId($request->program_studi);
                });
            }

            $query = $query->get()->map(function($item) {
              $item->tanggal = is_null($item->tugas_akhir->jadwal_seminar) ? null : $item->tugas_akhir->jadwal_seminar->tanggal;
              $item->jam_mulai = is_null($item->tugas_akhir->jadwal_seminar) ? null : $item->tugas_akhir->jadwal_seminar->jam_mulai;
              return $item;
            })->sortBy(function ($item) {
              return $item['jam_mulai'] ? Carbon::parse($item['jam_mulai']) : Carbon::parse('23:59');
            })->sortBy(function ($item) {
              return $item['tanggal'] ?? Carbon::parse('9999-12-31');
            });
        }
        $data = [
            'title' => 'Jadwal',
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
            'prodi' => ProgramStudi::all(),
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
            'item' => $jadwal,
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
            DB::beginTransaction();
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
                        'nilai' => $request->input('nilai_'.$category->id)
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
            $jadwal->update(['status' => 'telah_seminar']);
            DB::commit();

            return redirect()->back()->with(['success' => 'Nilai berhasil disimpan']);
        } catch(Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function cetakRevisi(JadwalSeminar $jadwal) 
    {
        $jdwl = JadwalSeminar::with(['tugas_akhir.bimbing_uji.revisi.bimbingUji.dosen','tugas_akhir.bimbing_uji.revisi.bimbingUji.tugas_akhir.mahasiswa'])->findOrFail($jadwal->id);
        $allRevisis = $jdwl->tugas_akhir->bimbing_uji->filter(function($bimbingUji) {
            return $bimbingUji->jenis === 'penguji';
        })->map(function ($bimbingUji) {
            if ($bimbingUji->revisi->isEmpty()) {
                return [
                    'revisi' => null,
                    'judul' => 'SEMINAR PROPOSAL',
                    'dosen' => $bimbingUji->dosen,
                ];
            }
            return $bimbingUji->revisi->filter(function ($revisi) {
                return $revisi->type == 'Seminar';
            })->map(function ($revisi) use ($bimbingUji) {
                return [
                    'revisi' => $revisi,
                    'judul' => 'SEMINAR PROPOSAL',
                    'dosen' => $bimbingUji->dosen,
                ];
            })->first();
        })->toArray();
        $bu = $jadwal->tugas_akhir->bimbing_uji()->where('jenis','pembimbing')->orderBy('urut', 'asc')->get();
        $data = [
            'title' => 'Lembar Revisi Seminar Proposal',
            'jadwal' => $jdwl,
            'rvs' => $allRevisis,
            'bimbingUji' => $bu,
        ];

        // return view('administrator.template.revisi', $data);
        $pdf = Pdf::loadView('administrator.template.revisi', $data);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream();
    }
    
    public function cetakNilai(JadwalSeminar $jadwal)
    {
        $jdwl = JadwalSeminar::with(['tugas_akhir.bimbing_uji.revisi.bimbingUji.dosen','tugas_akhir.bimbing_uji.revisi.bimbingUji.tugas_akhir.mahasiswa'])->findOrFail($jadwal->id);
        $query = $jdwl->tugas_akhir->bimbing_uji->map(function ($bimbingUji) {
            $nilaiSeminar = $bimbingUji->penilaian->filter(function ($nilai) {
                return $nilai->type == 'Seminar';
            });
            $totalNilaiAngka = $nilaiSeminar->avg('nilai');
            $totalNilaiHuruf = grade($totalNilaiAngka); 
            $peran = '';
            if ($bimbingUji->jenis == 'pembimbing') {
                $peran = 'Pembimbing ' . toRoman($bimbingUji->urut);
            } elseif ($bimbingUji->jenis == 'penguji') {
                $peran = 'Penguji ' . toRoman($bimbingUji->urut);
            }
            return [
                'tipe' => 'SEMINAR PROPOSAL',
                'peran' => $peran,
                'dosen' => $bimbingUji->dosen,
                'nilai' => $nilaiSeminar->map(function ($nilai) {
                    return [
                        'nilai' => $nilai->nilai,
                        'kategori_nilai' => $nilai->kategori->nama,
                        'nilai_huruf' => grade($nilai->nilai),
                    ];
                })->toArray(),
                'totalNilaiAngka' => number_format($totalNilaiAngka, 2),
                'totalNilaiHuruf' => $totalNilaiHuruf,
            ];
        });
        $query = $query->sortBy(function ($item) {
            $order = [
                'Pembimbing 1' => 1,
                'Pembimbing 2' => 2,
                'Penguji 1' => 3,
                'Penguji 2' => 4,
            ];
            return $order[$item['peran']] ?? 99;
        })->values()->toArray();
        $bu = $jadwal->tugas_akhir->bimbing_uji()->where('jenis','pembimbing')->orderBy('urut', 'asc')->get();
        $kategoriNilai = KategoriNilai::all();
        $data = [
            'title' => 'Lembar Penilaian',
            'judul' => 'Seminar Proposal',
            'nilai' => $query,
            'jadwal' => $jdwl,
            'bimbingUji' => $bu,
            'kategoriNilai' => $kategoriNilai
        ];
        $pdf = Pdf::loadView('administrator.template.lembar-penilaian', $data);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream();
        // return view('administrator.template.lembar-penilaian', $data);
    }
    
    public function cetakRekap(JadwalSeminar $jadwal)
    {
        $jdwl = JadwalSeminar::with(['tugas_akhir.bimbing_uji.revisi.bimbingUji.dosen','tugas_akhir.bimbing_uji.revisi.bimbingUji.tugas_akhir.mahasiswa'])->findOrFail($jadwal->id);
        $query = $jdwl->tugas_akhir->bimbing_uji->map(function ($bimbingUji) {
            $nilaiSeminar = $bimbingUji->penilaian->filter(function ($nilai) {
                return $nilai->type == 'Seminar';
            });
            $totalNilaiAngka = $nilaiSeminar->avg('nilai');
            $totalNilaiHuruf = grade($totalNilaiAngka); 
            $peran = '';
            if ($bimbingUji->jenis == 'pembimbing') {
                $peran = 'Pembimbing ' . toRoman($bimbingUji->urut);
            } elseif ($bimbingUji->jenis == 'penguji') {
                $peran = 'Penguji ' . toRoman($bimbingUji->urut);
            }
            return [
                'peran' => $peran,
                'dosen' => $bimbingUji->dosen,
                'nilai' => number_format($totalNilaiAngka, 2),
            ];
        })->toArray();

        $weights = [
            'Pembimbing I' => 0.30,
            'Pembimbing II' => 0.30,
            'Penguji I' => 0.20,
            'Penguji II' => 0.20,
        ];

        $rekap = [];
        $totalNilai = 0;
        $totalNilaiTertimbang = 0;

        foreach ($query as $item) {
            $peran = $item['peran'];
            if (isset($weights[$peran])) {
                $weightedValue = $weights[$peran] * $item['nilai'];
                $rekap[] = [
                    'penilai' => $peran,
                    'nilai' => number_format($item['nilai'], 2),
                    'persentase' => ($weights[$peran] * 100) . '% X ' . number_format($item['nilai'], 2) . ' = ' . number_format($weightedValue, 2),
                ];

                $totalNilai += $item['nilai'];
                $totalNilaiTertimbang += $weightedValue;
            }
        }
        $totalNilaiHuruf = grade($totalNilai / count($rekap));
        $pemb1 = $jadwal->tugas_akhir->bimbing_uji()->where('jenis','pembimbing')->where('urut', 1)->first();        
        $pemb2 = $jadwal->tugas_akhir->bimbing_uji()->where('jenis','pembimbing')->where('urut', 2)->first(); 
        
        $user = getInfoLogin()->userable;
        $programStudi = $user->programStudi;
        $dosen = Dosen::where('program_studi_id', $programStudi->id)->whereHas('user', function($q) { 
            $q->whereHas('roles', function ($q) {
                $q->where('name', 'Kaprodi');
            });
        })->first();
        $data = [
            'title' => 'Rekapitulasi Nilai',
            'tipe' => 'SEMINAR PROPOSAL',
            'rekap' => $rekap,
            'jumlah' => number_format($totalNilai, 2),
            'nilai_huruf' => $totalNilaiHuruf,
            'nilai_angka' => number_format($totalNilaiTertimbang, 2),
            'jadwal' => $jdwl,
            'pemb1' => $pemb1,
            'pemb2' => $pemb2,
            'kaprodi' => $dosen,
        ];

        $pdf = Pdf::loadView('administrator.template.rekapitulasi', $data);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream();
        // return view('administrator.template.rekapitulasi', $data);

    }

    public function updateStatus(Request $request, JadwalSeminar $jadwal)
    {
        $request->validate([
            'status' => 'required',
        ]);

        try {
            $jadwal->update([
                'status' => 'telah_seminar'
            ]);

            if($request->status == 'retrial') {
                $jadwal->update([
                    'status' => 'belum_terjadwal'
                ]);
                $jadwal->tugas_akhir->update(['status_seminar' => 'retrial']);

                return redirect()->back()->with(['success' => 'Berhasil memperbarui jadwal seminar']);
            }

            if($request->status == 'reject') {
                $jadwal->tugas_akhir->update(['status_seminar' => 'reject']);

                return redirect()->back()->with(['success' => 'Berhasil menolak jadwal seminar']);
            }

            $jadwal->tugas_akhir->update([
                'status_seminar' => $request->status, 
            ]);

            return redirect()->back()->with(['success' => 'Berhasil mengubah status']);
        } catch(Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function revisionValid(Revisi $revisi)
    {
        try {
            $revisi->update(['is_valid' => true]);
            return redirect()->route('apps.jadwal')->with(['success' => 'Berhasil memperbarui status revisi']);
        } catch(Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function mentorValidation(Revisi $revisi)
    {
        try {
            $revisi->update(['is_mentor_validation' => true]);
            return redirect()->back()->with(['success' => 'Berhasil memperbarui status revisi']);
        } catch(Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
}
