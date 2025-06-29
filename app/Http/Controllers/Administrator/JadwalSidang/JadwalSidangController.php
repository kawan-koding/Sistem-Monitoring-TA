<?php

namespace App\Http\Controllers\Administrator\JadwalSidang;

use App\Exports\SemproExport;
use Exception;
use Carbon\Carbon;
use App\Models\Dosen;
use App\Models\Revisi;
use App\Models\Sidang;
use App\Models\Ruangan;
use App\Models\Mahasiswa;
use App\Models\Penilaian;
use App\Models\PeriodeTa;
use App\Models\BimbingUji;
use App\Models\Pemberkasan;
use App\Models\JenisDokumen;
use Illuminate\Http\Request;
use App\Models\KategoriNilai;
use App\Exports\SemuaDataTaExport;
use Illuminate\Support\Facades\DB;
use App\Exports\SKSidangAkhirExport;
use App\Http\Controllers\Controller;
use App\Models\JadwalSeminar;
use App\Models\ProgramStudi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

class JadwalSidangController extends Controller
{
    public function index(Request $request, $jenis = 'pembimbing')
    {
        $query = [];
        $periode = $request->has('filter2') && !empty($request->filter2 && $request->filter2 != 'semua') ? [$request->filter2] : PeriodeTa::where('is_active', 1)->get()->pluck('id')->toArray();
        $query = Sidang::with(['tugas_akhir']);
        if (getInfoLogin()->hasRole('Mahasiswa')) {
            $myId = getInfoLogin()->userable;
            $mahasiswa = Mahasiswa::where('id', $myId->id)->first();
            if ($mahasiswa) {
                $query->whereHas('tugas_akhir', function ($q) use ($periode, $mahasiswa) {
                    $q->whereIn('periode_ta_id', $periode)->where('mahasiswa_id', $mahasiswa->id);
                });
                $query = $query->get();
            }
        }

        if (getInfoLogin()->hasRole('Dosen')) {
            $user = getInfoLogin()->userable;
            if ($jenis == 'penguji') {
                $query = BimbingUji::where('dosen_id', $user->id)->whereIn('jenis', ['penguji', 'pengganti'])->whereHas('tugas_akhir', function ($q) use ($periode) {
                    $q->where('periode_ta_id', $periode)->whereHas('sidang', function ($q) {
                        $q->whereIn('status', ['sudah_daftar', 'sudah_terjadwal', 'sudah_sidang']);
                    });
                })->get();
            } else {
                $query = BimbingUji::where('dosen_id', $user->id)->where('jenis', $jenis)->whereHas('tugas_akhir', function ($q) use ($periode) {
                    $q->where('periode_ta_id', $periode)->whereHas('sidang', function ($q) {
                        $q->whereIn('status', ['sudah_daftar', 'sudah_terjadwal', 'sudah_sidang']);
                    });
                })->get();
            }
        }

        if (getInfoLogin()->hasRole('Admin')) {
            $query = $query->whereHas('tugas_akhir', function ($q) use ($periode) {
                $q->where('is_completed', 1)->whereIn('periode_ta_id', $periode);
            });

            if ($request->has('tanggal') && !empty($request->tanggal)) {
                $query = $query->whereDate('tanggal', $request->tanggal);
            }

            if ($request->has('status') && !empty($request->status)) {
                if ($request->status == 'sudah_sidang') {
                    $query = $query->where('status', $request->status)->whereHas('tugas_akhir', function ($q) use ($request) {
                        $q->where('status_pemberkasan_sidang', 'belum_lengkap');
                    });
                } else {
                    $query = $query->where('status', $request->status)->whereHas('tugas_akhir', function ($q) use ($request) {
                        $q->whereNull('status_sidang');
                    });
                }
            } else {
                if ($request->has('status_pemberkasan_sidang') && !empty($request->status_pemberkasan_sidang)) {
                    $query = $query->whereHas('tugas_akhir', function ($q) use ($request) {
                        $q->where('status_pemberkasan_sidang', $request->status_pemberkasan_sidang);
                    });
                } else {
                    $query = $query->where('status', 'belum_daftar')->whereHas('tugas_akhir', function ($q) use ($request) {
                        $q->where('status_pemberkasan_sidang', 'belum_lengkap')->where('status_pemberkasan', 'sudah_lengkap');
                    });
                }
            }

            if ($request->has('filter1') && !empty($request->filter1) && $request->filter1 != 'semua') {
                $query = $query->whereHas('tugas_akhir', function ($q) use ($request) {
                    $q->whereHas('mahasiswa', function ($q) use ($request) {
                        $q->where('program_studi_id', $request->filter1);
                    });
                });
            }

            if ($request->has('type') && !empty($request->type) && $request->type != 'semua') {
                $query = $query->wherehas('tugas_akhir', function ($q) use ($request) {
                    $q->whereTipe($request->type);
                });
            }

            $query = $query->get();

            // dd($query);

            $query = $query->map(function ($item) {
                $jenisDocument = JenisDokumen::whereIn('jenis', ['sidang', 'pra_sidang'])->count();
                $jenisDocumentComplete = JenisDokumen::whereIn('jenis', ['sidang', 'pra_sidang'])->whereHas('pemberkasan', function ($q) use ($item) {
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
            'breadcrumbs' => [
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
            'status_pemberkasan_sidang' => $request->has('status_pemberkasan_sidang') ? $request->status_pemberkasan_sidang : null,
            'document_sidang' => $docSidang,
            'periodes' => $request->has('filter1') && $request->filter1 != 'semua' ? PeriodeTa::where('program_studi_id', $request->filter1)->get() : PeriodeTa::whereIsActive(true)->get(),
            'programStudies' => ProgramStudi::all(),
            'periode' => $periode,
            'filter1' => $request->has('filter1') ? $request->filter1 : null,
            'filter2' => $request->has('filter2') ? $request->filter2 : null,
            'prodi' => ProgramStudi::all(),
            'type' => $request->has('type') ? $request->type : null
        ];

        return view('administrator.jadwal-sidang.index', $data);
    }

    public function edit(Sidang $jadwalSidang)
    {
        $currentWeekDays = [];
        $i = 0;

        while (count($currentWeekDays) <= 7) {
            $date = Carbon::now()->addDays($i);

            if ($date->isWeekday()) {
                $currentWeekDays[] = $date->format('Y-m-d');
            }

            $i++;
        }
        // dd($jadwalSidang);
        $data = [
            'title' => 'Jadwal Sidang',
            'mods' => 'jadwal_sidang',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard'),
                ],
                [
                    'title' => 'Jadwal Sidang',
                    'is_active' => true,
                ]
            ],
            'jadwalSidang' => $jadwalSidang,
            'ruangan' => Ruangan::all(),
            'editedData' => $jadwalSidang,
            'jadwalPembimbing1' => Sidang::whereHas('tugas_akhir', function ($query) use ($jadwalSidang) {
                $query->whereHas('bimbing_uji', function ($query) use ($jadwalSidang) {
                    $dosenId = $jadwalSidang->tugas_akhir->bimbing_uji()->where('jenis', 'pembimbing')->where('urut', 1)->first();
                    $dosenId = is_null($dosenId) ? null : $dosenId->dosen_id;

                    if (is_null($dosenId)) {
                        $query->whereNull('dosen_id');
                    } else {
                        $query->where('dosen_id', $dosenId);
                    }
                });
            })->whereDate('tanggal', '>=', Carbon::today()->format('Y-m-d'))->whereNot('id', $jadwalSidang->id)->where('status', 'sudah_terjadwal')->orderBy('jam_mulai', 'asc')->orderBy('tanggal', 'asc')->get(),
            'jadwalPembimbing2' => Sidang::whereHas('tugas_akhir', function ($query) use ($jadwalSidang) {
                $query->whereHas('bimbing_uji', function ($query) use ($jadwalSidang) {
                    $dosenId = $jadwalSidang->tugas_akhir->bimbing_uji()->where('jenis', 'pembimbing')->where('urut', 2)->first();
                    $dosenId = is_null($dosenId) ? null : $dosenId->dosen_id;

                    if (is_null($dosenId)) {
                        $query->whereNull('dosen_id');
                    } else {
                        $query->where('dosen_id', $dosenId);
                    }
                });
            })->whereDate('tanggal', '>=', Carbon::today()->format('Y-m-d'))->whereNot('id', $jadwalSidang->id)->where('status', 'sudah_terjadwal')->orderBy('jam_mulai', 'asc')->orderBy('tanggal', 'asc')->get(),
            'jadwalPenguji1' => Sidang::whereHas('tugas_akhir', function ($query) use ($jadwalSidang) {
                $query->whereHas('bimbing_uji', function ($query) use ($jadwalSidang) {
                    $dosenId = $jadwalSidang->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', 1)->first();
                    $dosenId = is_null($dosenId) ? null : $dosenId->dosen_id;

                    if (is_null($dosenId)) {
                        $query->whereNull('dosen_id');
                    } else {
                        $query->where('dosen_id', $dosenId);
                    }
                });
            })->whereDate('tanggal', '>=', Carbon::today()->format('Y-m-d'))->whereNot('id', $jadwalSidang->id)->where('status', 'sudah_terjadwal')->orderBy('jam_mulai', 'asc')->orderBy('tanggal', 'asc')->get(),
            'jadwalPenguji2' => Sidang::whereHas('tugas_akhir', function ($query) use ($jadwalSidang) {
                $query->whereHas('bimbing_uji', function ($query) use ($jadwalSidang) {
                    $dosenId = $jadwalSidang->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', 2)->first();
                    $dosenId = is_null($dosenId) ? null : $dosenId->dosen_id;

                    if (is_null($dosenId)) {
                        $query->whereNull('dosen_id');
                    } else {
                        $query->where('dosen_id', $dosenId);
                    }
                });
            })->whereDate('tanggal', '>=', Carbon::today()->format('Y-m-d'))->whereNot('id', $jadwalSidang->id)->where('status', 'sudah_terjadwal')->orderBy('jam_mulai', 'asc')->orderBy('tanggal', 'asc')->get(),
            'mahasiswaTerdaftar' => Sidang::where('status', 'sudah_terjadwal')->whereIn('tanggal', $currentWeekDays)->orderBy('jam_mulai', 'asc')->orderBy('tanggal', 'asc')->get(),
            'pengujiPengganti' => Dosen::all(),
        ];

        // dd($data);
        return view('administrator.jadwal-sidang.form', $data);
    }

    public function update(Request $request, Sidang $jadwalSidang)
    {
        $request->validate(
            [
                'ruangan' => 'required',
                'tanggal' => 'required',
                'jam_mulai' => 'required',
                'jam_selesai' => 'required',
            ],
            [
                'ruangan.required' => 'Ruangan harus diisi',
                'tanggal.required' => 'Tanggal harus diisi',
                'jam_mulai.required' => 'Jam mulai harus diisi',
                'jam_selesai.required' => 'Jam selesai harus diisi',
            ]
        );
        try {
            $periode = PeriodeTa::where('is_active', 1)->where('program_studi_id', $jadwalSidang->tugas_akhir->mahasiswa->program_studi_id)->first();
            if (!is_null($periode) && Carbon::createFromFormat('Y-m-d', $request->tanggal)->greaterThan(Carbon::parse($periode->akhir_sidang))) {
                return redirect()->back()->with(['error' => 'Jadwal sidang melebihi batas periode']);
            }
            if (!is_null($periode) && !Carbon::createFromFormat('Y-m-d', $request->tanggal)->greaterThan(Carbon::parse($periode->mulai_sidang))) {
                return redirect()->back()->with(['error' => 'Periode sidang belum aktif']);
            }

            $check = Sidang::whereNot('id', $jadwalSidang->id)->whereHas('tugas_akhir', function ($q) use ($jadwalSidang) {
                $q->whereHas('bimbing_uji', function ($q) use ($jadwalSidang) {
                    $q->whereIn('dosen_id', $jadwalSidang->tugas_akhir->bimbing_uji->pluck('dosen_id')->toArray());
                });
            })->whereDate('tanggal', $request->tanggal)->whereStatus('sudah_terjadwal')->where('jam_mulai', '>=', $request->jam_mulai)->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])->first();

            if (is_null($check)) {
                $check = JadwalSeminar::whereHas('tugas_akhir', function ($q) use ($jadwalSidang) {
                    $q->whereHas('bimbing_uji', function ($q) use ($jadwalSidang) {
                        $q->whereIn('dosen_id', $jadwalSidang->tugas_akhir->bimbing_uji()->pluck('dosen_id')->toArray());
                    });
                })->whereDate('tanggal', $request->tanggal)->whereStatus('sudah_terjadwal')->where('jam_mulai', '>=', $request->jam_mulai)->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])->first();
            }

            $checkRuangan = Sidang::whereNot('id', $jadwalSidang->id)->whereRuanganId($request->ruangan)->whereDate('tanggal', $request->tanggal)->whereStatus('sudah_terjadwal')->where('jam_mulai', '>=', $request->jam_mulai)->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])->first();

            if (is_null($checkRuangan)) {
                $checkRuangan = JadwalSeminar::whereRuanganId($request->ruangan)->whereDate('tanggal', $request->tanggal)->whereStatus('sudah_terjadwal')->where('jam_mulai', '>=', $request->jam_mulai)->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])->first();
            }

            if (!is_null($check)) {
                return redirect()->back()->withInput($request->all())->with(['error' => 'Jadwal ini sudah ada']);
            }

            if (!is_null($checkRuangan)) {
                return redirect()->back()->withInput($request->all())->with(['error' => 'Ruangan sudah digunakan pada waktu tersebut']);
            }

            $jadwalSidang->update([
                'ruangan_id' => $request->ruangan,
                'tanggal' => $request->tanggal,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'status' => 'sudah_terjadwal'
            ]);
            // $jadwalSidang->tugas_akhir->update(['status_sidang' => null, 'status_pemberkasan' => 'belum_lengkap']);
            $rating = Penilaian::where('type', 'Sidang')->whereIn('bimbing_uji_id', $jadwalSidang->tugas_akhir->bimbing_uji->pluck('id'));
            if ($rating->count() > 0) {
                $rating->delete();
            }

            // delete revisi
            // $revisi = Revisi::whereIn('bimbing_uji_id', $jadwalSidang->tugas_akhir->bimbing_uji->pluck('id'));
            // if($revisi->count() > 0) {
            //     $revisi->delete();
            // }

            if ($request->has('pengganti1') && !empty($request->pengganti1)) {
                $cek = BimbingUji::where('tugas_akhir_id', $jadwalSidang->tugas_akhir_id)->where('jenis', 'pengganti')->where('urut', 1);
                if ($cek->count() > 0) {
                    $cek->update(['dosen_id' => $request->pengganti1]);
                } else {
                    BimbingUji::create([
                        'tugas_akhir_id' => $jadwalSidang->tugas_akhir_id,
                        'dosen_id' => $request->pengganti1,
                        'jenis' => 'pengganti',
                        'urut' => 1
                    ]);
                }
            } else {
                $cek = BimbingUji::where('tugas_akhir_id', $jadwalSidang->tugas_akhir_id)->where('jenis', 'pengganti')->where('urut', 1);
                if ($cek->count() > 0) {
                    $cek->delete();
                }
            }

            if ($request->has('pengganti2') && !empty($request->pengganti2)) {
                $cek = BimbingUji::where('tugas_akhir_id', $jadwalSidang->tugas_akhir_id)->where('jenis', 'pengganti')->where('urut', 2);
                if ($cek->count() > 0) {
                    $cek->update(['dosen_id' => $request->pengganti2]);
                } else {
                    BimbingUji::create([
                        'tugas_akhir_id' => $jadwalSidang->tugas_akhir_id,
                        'dosen_id' => $request->pengganti2,
                        'jenis' => 'pengganti',
                        'urut' => 2
                    ]);
                }
            } else {
                $cek = BimbingUji::where('tugas_akhir_id', $jadwalSidang->tugas_akhir_id)->where('jenis', 'pengganti')->where('urut', 2);
                if ($cek->count() > 0) {
                    $cek->delete();
                }
            }

            return redirect()->route('apps.jadwal-sidang')->with(['success' => 'Berhasil menyimpan data']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function detail(Sidang $sidang)
    {
        $recapPemb1 = $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'pembimbing')->where('urut', 1)->first()->penilaian()->where('type', 'Sidang')->sum('nilai');
        $recapPemb1 = $recapPemb1 > 0 ? $recapPemb1 / $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'pembimbing')->where('urut', 1)->first()->penilaian()->where('type', 'Sidang')->count() : 0;
        $recapPemb2 = $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'pembimbing')->where('urut', 2)->first()->penilaian()->where('type', 'Sidang')->sum('nilai');
        $recapPemb2 = $recapPemb2 > 0 ? $recapPemb2 / $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'pembimbing')->where('urut', 2)->first()->penilaian()->where('type', 'Sidang')->count() : 0;
        $recapPenguji1 = $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'pengganti')->where('urut', 1)->count() > 0 ? $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'pengganti')->where('urut', 1)->first()->penilaian()->where('type', 'Sidang')->sum('nilai') : $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', 1)->first()->penilaian()->where('type', 'Sidang')->sum('nilai');
        $recapPenguji1 = $recapPenguji1 > 0 ? $recapPenguji1 / ($sidang->tugas_akhir->bimbing_uji()->where('jenis', 'pengganti')->where('urut', 1)->count() > 0 ? $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'pengganti')->where('urut', 1)->first()->penilaian()->where('type', 'Sidang')->count() : $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', 1)->first()->penilaian()->where('type', 'Sidang')->count()) : 0;
        $recapPenguji2 = $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'pengganti')->where('urut', 2)->count() > 0 ? $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'pengganti')->where('urut', 2)->first()->penilaian()->where('type', 'Sidang')->sum('nilai') : $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', 2)->first()->penilaian()->where('type', 'Sidang')->sum('nilai');
        $recapPenguji2 = $recapPenguji2 > 0 ? $recapPenguji2 / ($sidang->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', 2)->first()->penilaian()->where('type', 'Sidang')->count() ? $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'pengganti')->where('urut', 2)->first()->penilaian()->where('type', 'Sidang')->count() : $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', 2)->first()->penilaian()->where('type', 'Sidang')->count()) : 0;

        $data = [
            'title' => 'Jadwal Sidang',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard'),
                ],
                [
                    'title' => 'Jadwal Sidang',
                    'url' => route('apps.jadwal-seminar'),
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

    public function show(Sidang $sidang)
    {
        $pembimbing1 = $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'pembimbing')->where('urut', 1)->first();
        $recapPemb1 = isset($pembimbing1->penilaian) ? $pembimbing1->penilaian()->where('type', 'Sidang')->sum('nilai') : 0;
        $countPemb1 = isset($pembimbing1->penilaian) ? $pembimbing1->penilaian()->where('type', 'Sidang')->count() : 0;
        $recapPemb1 = $countPemb1 > 0 ? $recapPemb1 / $countPemb1 : 0;
        $pembimbing2 = $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'pembimbing')->where('urut', 2)->first();
        $recapPemb2 = isset($pembimbing2->penilaian) ? $pembimbing2->penilaian()->where('type', 'Sidang')->sum('nilai') : 0;
        $countPemb2 = isset($pembimbing2->penilaian) ? $pembimbing2->penilaian()->where('type', 'Sidang')->count() : 0;
        $recapPemb2 = $countPemb2 > 0 ? $recapPemb2 / $countPemb2 : 0;
        $pengganti1 = $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'pengganti')->where('urut', 1)->first();
        $penguji1 = $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', 1)->first();
        $recapPenguji1 = isset($pengganti1->penilaian) ? $pengganti1->penilaian()->where('type', 'Sidang')->sum('nilai') : (isset($penguji1->penilaian) ? $penguji1->penilaian()->where('type', 'Sidang')->sum('nilai') : 0);
        $countPenguji1 = isset($pengganti1->penilaian) ? $pengganti1->penilaian()->where('type', 'Sidang')->count() : (isset($penguji1->penilaian) ? $penguji1->penilaian()->where('type', 'Sidang')->count() : 0);
        $recapPenguji1 = $countPenguji1 > 0 ? $recapPenguji1 / $countPenguji1 : 0;
        $pengganti2 = $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'pengganti')->where('urut', 2)->first();
        $penguji2 = $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', 2)->first();
        $recapPenguji2 = isset($pengganti2->penilaian) ? $pengganti2->penilaian()->where('type', 'Sidang')->sum('nilai') : (isset($penguji2->penilaian) ? $penguji2->penilaian()->where('type', 'Sidang')->sum('nilai') : 0);
        $countPenguji2 = isset($pengganti2->penilaian) ? $pengganti2->penilaian()->where('type', 'Sidang')->count() : (isset($penguji2->penilaian) ? $penguji2->penilaian()->where('type', 'Sidang')->count() : 0);
        $recapPenguji2 = $countPenguji2 > 0 ? $recapPenguji2 / $countPenguji2 : 0;

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
            'nilais' => getInfoLogin()->hasRole('Mahasiswa') ? null : $sidang->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->penilaian()->where('type', 'sidang')->get(),
            'bimbingUjis' => $sidang->tugas_akhir->bimbing_uji()->orderBy('jenis', 'desc')->orderBy('urut', 'asc')->get(),
            'recapPemb1' => $recapPemb1,
            'recapPemb2' => $recapPemb2,
            'recapPenguji1' => $recapPenguji1,
            'recapPenguji2' => $recapPenguji2
        ];

        return view('administrator.jadwal-sidang.detail', $data);
    }

    public function register(Sidang $sidang, Request $request)
    {
        try {
            DB::beginTransaction();
            $periode = PeriodeTa::where('is_active', true)->where('program_studi_id', $sidang->tugas_akhir->mahasiswa->program_studi_id)->first();
            if (!is_null($periode) && !Carbon::parse($periode->akhir_sidang)->addDays(1)->isFuture()) {
                return redirect()->back()->with('error', 'Pendaftaran sidang melebihi batas periode');
            }
            if (!is_null($periode) && Carbon::parse($periode->mulai_sidang)->addDays(1)->isFuture()) {
                return redirect()->back()->with('error', 'Pendaftaran Sidang Akhir belum aktif');
            }
            $documentTypes = JenisDokumen::all();
            $validates = [];
            $messages = [];
            $inserts = [];
            foreach ($documentTypes as $item) {
                if ($sidang->status == 'belum_terjadwal') {
                    if ($item->jenis == 'pra_sidang') {
                        $validates['document_' . $item->id] = $item->tipe_dokumen == 'pdf' ? '|mimes:pdf|max:' . $item->max_ukuran : 'mimes:png,jpg,jpeg,webp|max:' . $item->max_ukuran;
                        $messages['document_' . $item->id . '.mimes'] = 'Dokumen ' . strtolower($item->nama) . ' harus dalam format ' . ($item->tipe_dokumen == 'pdf' ? 'PDF' : 'PNG, JPEG, JPG, WEBP');
                        $messages['document_' . $item->id . '.max'] = 'Dokumen ' . strtolower($item->nama) . ' tidak boleh lebih dari ' . $item->max_ukuran . ' KB';
                    }
                } else {
                    if ($item->jenis == 'sidang') {
                        $validates['document_' . $item->id] = $item->tipe_dokumen == 'pdf' ? '|mimes:pdf|max:' . $item->max_ukuran : 'mimes:png,jpg,jpeg,webp|max:' . $item->max_ukuran;
                        $messages['document_' . $item->id . '.mimes'] = 'Dokumen ' . strtolower($item->nama) . ' harus dalam format ' . ($item->tipe_dokumen == 'pdf' ? 'PDF' : 'PNG, JPEG, JPG, WEBP');
                        $messages['document_' . $item->id . '.max'] = 'Dokumen ' . strtolower($item->nama) . ' tidak boleh lebih dari ' . $item->max_ukuran . ' KB';
                    }
                }
            }

            $request->validate($validates, $messages);

            foreach ($documentTypes as $item) {
                if ($sidang->status == 'belum_daftar') {
                    if ($item->jenis == 'pra_sidang' && $request->hasFile('document_' . $item->id)) {
                        $file = $request->file('document_' . $item->id);
                        $filename = 'document_' . rand(0, 999999999) . '_' . rand(0, 999999999) . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('storage/files/pemberkasan'), $filename);

                        $document = $item->pemberkasan()->where('tugas_akhir_id', $sidang->tugas_akhir->id)->first();
                        if ($document) {
                            File::delete(public_path('storage/files/pemberkasan/' . $document->filename));
                            $document->update([
                                'filename' => $filename
                            ]);
                        } else {
                            $inserts[] = [
                                'tugas_akhir_id' => $sidang->tugas_akhir->id,
                                'jenis_dokumen_id' => $item->id,
                                'filename' => $filename,
                                'updated_at' => now(),
                                'created_at' => now()
                            ];
                        }
                    }
                } else {
                    if (($item->jenis == 'sidang' || $item->jenis == 'pra_sidang')  && $request->hasFile('document_' . $item->id)) {
                        $file = $request->file('document_' . $item->id);
                        $filename = 'document_' . rand(0, 999999999) . '_' . rand(0, 999999999) . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('storage/files/pemberkasan'), $filename);
                        $document = $item->pemberkasan()->where('tugas_akhir_id', $sidang->tugas_akhir->id)->first();
                        if ($document) {
                            File::delete(public_path('storage/files/pemberkasan/' . $document->filename));
                            $document->update([
                                'filename' => $filename
                            ]);
                        } else {
                            $inserts[] = [
                                'tugas_akhir_id' => $sidang->tugas_akhir->id,
                                'jenis_dokumen_id' => $item->id,
                                'filename' => $filename,
                                'updated_at' => now(),
                                'created_at' => now()
                            ];
                        }
                    }
                }
            }
            if (count($inserts) > 0) {
                Pemberkasan::insert($inserts);
            }

            $sidang->update(['status' => 'sudah_daftar']);
            DB::commit();
            return redirect()->back()->with(['success' => 'Dokumen berhasil ditambahkan']);
        } catch (Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function uploadFile(Sidang $sidang, Request $request)
    {
        try {
            DB::beginTransaction();
            $periode = PeriodeTa::where('is_active', true)->first();
            if (!is_null($periode) && !Carbon::parse($periode->akhir_sidang)->addDays(1)->isFuture()) {
                return redirect()->back()->with('error', 'Pendaftaran sidang melebihi batas periode');
            }
            if (!is_null($periode) && Carbon::parse($periode->mulai_sidang)->addDays(1)->isFuture()) {
                return redirect()->back()->with('error', 'Pendaftaran Sidang Akhir belum aktif');
            }
            $documentTypes = JenisDokumen::all();
            $validates = [];
            $messages = [];
            $inserts = [];
            foreach ($documentTypes as $item) {
                if ($sidang->status == 'belum_terjadwal') {
                    if ($item->jenis == 'pra_sidang') {
                        $validates['document_' . $item->id] = $item->tipe_dokumen == 'pdf' ? '|mimes:pdf|max:' . $item->max_ukuran : 'mimes:png,jpg,jpeg,webp|max:' . $item->max_ukuran;
                        $messages['document_' . $item->id . '.mimes'] = 'Dokumen ' . strtolower($item->nama) . ' harus dalam format ' . ($item->tipe_dokumen == 'pdf' ? 'PDF' : 'PNG, JPEG, JPG, WEBP');
                        $messages['document_' . $item->id . '.max'] = 'Dokumen ' . strtolower($item->nama) . ' tidak boleh lebih dari ' . $item->max_ukuran . ' KB';
                    }
                } else {
                    if ($item->jenis == 'sidang') {
                        $validates['document_' . $item->id] = $item->tipe_dokumen == 'pdf' ? '|mimes:pdf|max:' . $item->max_ukuran : 'mimes:png,jpg,jpeg,webp|max:' . $item->max_ukuran;
                        $messages['document_' . $item->id . '.mimes'] = 'Dokumen ' . strtolower($item->nama) . ' harus dalam format ' . ($item->tipe_dokumen == 'pdf' ? 'PDF' : 'PNG, JPEG, JPG, WEBP');
                        $messages['document_' . $item->id . '.max'] = 'Dokumen ' . strtolower($item->nama) . ' tidak boleh lebih dari ' . $item->max_ukuran . ' KB';
                    }
                }
            }

            $request->validate($validates, $messages);

            foreach ($documentTypes as $item) {
                if ($sidang->status == 'belum_daftar') {
                    if ($item->jenis == 'pra_sidang' && $request->hasFile('document_' . $item->id)) {
                        $file = $request->file('document_' . $item->id);
                        $filename = 'document_' . rand(0, 999999999) . '_' . rand(0, 999999999) . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('storage/files/pemberkasan'), $filename);

                        $document = $item->pemberkasan()->where('tugas_akhir_id', $sidang->tugas_akhir->id)->first();
                        if ($document) {
                            File::delete(public_path('storage/files/pemberkasan/' . $document->filename));
                            $document->update([
                                'filename' => $filename
                            ]);
                        } else {
                            $inserts[] = [
                                'tugas_akhir_id' => $sidang->tugas_akhir->id,
                                'jenis_dokumen_id' => $item->id,
                                'filename' => $filename,
                                'updated_at' => now(),
                                'created_at' => now()
                            ];
                        }
                    }
                } else {
                    if (($item->jenis == 'sidang' || $item->jenis == 'pra_sidang') && $request->hasFile('document_' . $item->id)) {
                        $file = $request->file('document_' . $item->id);
                        $filename = 'document_' . rand(0, 999999999) . '_' . rand(0, 999999999) . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('storage/files/pemberkasan'), $filename);
                        $document = $item->pemberkasan()->where('tugas_akhir_id', $sidang->tugas_akhir->id)->first();
                        if ($document) {
                            File::delete(public_path('storage/files/pemberkasan/' . $document->filename));
                            $document->update([
                                'filename' => $filename
                            ]);
                        } else {
                            $inserts[] = [
                                'tugas_akhir_id' => $sidang->tugas_akhir->id,
                                'jenis_dokumen_id' => $item->id,
                                'filename' => $filename,
                                'updated_at' => now(),
                                'created_at' => now()
                            ];
                        }
                    }
                }
            }
            if (count($inserts) > 0) {
                Pemberkasan::insert($inserts);
            }
            DB::commit();
            return redirect()->back()->with(['success' => 'Dokumen berhasil ditambahkan']);
        } catch (Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function validasiBerkas(Sidang $jadwalSidang)
    {
        try {
            $jadwalSidang->tugas_akhir()->update(['status_pemberkasan_sidang' => 'sudah_lengkap']);

            return redirect()->back()->with(['success' => 'Berkas berhasil diperbarui']);
        } catch (Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }


    public function nilai(Request $request, Sidang $sidang)
    {
        try {
            DB::beginTransaction();
            $categories = KategoriNilai::all();
            $ratings = [];

            foreach ($categories as $category) {
                $request->validate([
                    'nilai_' . $category->id => 'required'
                ]);

                // check if exist
                $check = $sidang->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->penilaian()->where('kategori_nilai_id', $category->id)->where('type', 'Sidang')->first();

                if ($check) {
                    $check->update([
                        'nilai' => $request->input('nilai_' . $category->id)
                    ]);
                } else {
                    $ratings[] = [
                        'bimbing_uji_id' => $sidang->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->id,
                        'kategori_nilai_id' => $category->id,
                        'nilai' => $request->input('nilai_' . $category->id),
                        'type' => 'Sidang',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            if (count($ratings) > 0) {
                Penilaian::insert($ratings);
            }
            $sidang->update(['status' => 'sudah_sidang']);
            DB::commit();

            return redirect()->back()->with(['success' => 'Nilai berhasil disimpan']);
        } catch (Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function revisi(Request $request, Sidang $sidang)
    {
        $request->validate([
            'revisi' => 'required'
        ]);

        try {
            // get penguji
            $bimbingUji = $sidang->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first();

            // check revisi
            $check = Revisi::where('bimbing_uji_id', $bimbingUji->id)->where('type', 'Sidang');

            if ($check->count() > 0) {
                $check->update(['catatan' => $request->revisi]);
            } else {
                // insert revision
                Revisi::create([
                    'bimbing_uji_id' => $bimbingUji->id,
                    'type' => 'Sidang',
                    'catatan' => $request->revisi,
                ]);
            }

            return redirect()->back()->with(['success' => 'Revisi berhasil disimpan']);
        } catch (Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function updateStatus(Request $request, Sidang $sidang)
    {
        $request->validate([
            'status' => 'required',
        ]);

        try {
            if ($request->status == 'retrial') {
                $sidang->tugas_akhir->update([
                    'status_sidang' => 'retrial',
                ]);
                Sidang::create([
                    'tugas_akhir_id' => $sidang->tugas_akhir_id,
                    'status' => 'sudah_daftar'
                ]);
                $sidang->delete();
                return redirect()->route('apps.jadwal-sidang')->with(['success' => 'Berhasil menolak  sidang']);
            } else {
                $sidang->tugas_akhir->update([
                    'status_sidang' => $request->status,
                ]);
            }

            return redirect()->back()->with(['success' => 'Berhasil mengubah status']);
        } catch (Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function export(Request $request)
    {
        $status = $request->input('data');
        $title = '';
        $export = null;
        switch ($status) {
            case 'sk_sidang':
                $export = new SKSidangAkhirExport();
                $title = 'SK SIDANG';
                break;
            case 'belum_daftar':
                $export = new SemuaDataTaExport($status);
                $title = 'Belum Daftar Sidang';
                break;
            case 'sudah_terjadwal_sidang':
                $export = new SemuaDataTaExport($status);
                $title = 'Sudah Terjadwal Sidang';
                break;
            case 'sudah_sidang':
                $export = new SemuaDataTaExport($status);
                $title = 'Sudah Selesai Sidang';
                break;
            case 'sudah_daftar':
                $export = new SemuaDataTaExport($status);
                $title = 'Sudah Daftar Sidang';
                break;
            case 'sudah_pemberkasan_sidang':
                $export = new SemuaDataTaExport($status);
                $title = 'Sudah Pemberkasan Sidang';
                break;
            default:
                return redirect()->back()->with('error', 'Jenis export tidak valid.');
        }

        $sheets = $export->sheets();
        if (empty($sheets) || count($sheets) === 1 && $sheets[0] instanceof DummySheet) {
            return redirect()->back()->with('error', 'Data Tidak Ditemukan.');
        }

        return Excel::download($export, "{$title}.xlsx");
    }

    public function cetakRevisi(Sidang $sidang)
    {
        $jdwl = Sidang::with(['tugas_akhir.bimbing_uji.revisi.bimbingUji.dosen', 'tugas_akhir.bimbing_uji.revisi.bimbingUji.tugas_akhir.mahasiswa'])->findOrFail($sidang->id);
        $allRevisis = $jdwl->tugas_akhir->bimbing_uji->filter(function ($bimbingUji) {
            return $bimbingUji->jenis === 'penguji';
        })->flatMap(function ($bimbingUji) {
            if ($bimbingUji->revisi->isEmpty()) {
                return [];
            }
            return $bimbingUji->revisi->filter(function ($revisi) {
                return $revisi->type == 'Sidang';
            })->map(function ($revisi) use ($bimbingUji) {
                return [
                    'revisi' => $revisi,
                    'judul' => 'SIDANG AKHIR',
                    'dosen' => $bimbingUji->dosen,
                ];
            });
        })->toArray();
        $bu = $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'pembimbing')->orderBy('urut', 'asc')->get();
        $data = [
            'title' => 'Lembar Revisi Sidang Akhir',
            'jadwal' => $jdwl,
            'rvs' => $allRevisis,
            'bimbingUji' => $bu,
        ];

        $pdf = Pdf::loadView('administrator.template.revisi', $data);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream();
        // return view('administrator.template.revisi', $data);
    }

    public function cetakNilai(Sidang $sidang)
    {
        $jdwl = Sidang::with(['tugas_akhir.bimbing_uji.revisi.bimbingUji.dosen', 'tugas_akhir.bimbing_uji.revisi.bimbingUji.tugas_akhir.mahasiswa'])->findOrFail($sidang->id);
        $query = $jdwl->tugas_akhir->bimbing_uji->map(function ($bimbingUji) {
            $nilaiSeminar = $bimbingUji->penilaian->filter(function ($nilai) {
                return $nilai->type == 'Sidang';
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
                'tipe' => 'SIDANG AKHIR',
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
        $bu = $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'pembimbing')->orderBy('urut', 'asc')->get();
        $data = [
            'title' => 'Lembar Penilaian',
            'judul' => 'Sidang Akhir',
            'nilai' => $query,
            'jadwal' => $jdwl,
            'bimbingUji' => $bu,
        ];

        $pdf = Pdf::loadView('administrator.template.lembar-penilaian', $data);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream();
        // return view('administrator.template.lembar-penilaian', $data);
    }

    public function cetakRekap(Sidang $sidang)
    {
        $jdwl = Sidang::with(['tugas_akhir.bimbing_uji.revisi.bimbingUji.dosen', 'tugas_akhir.bimbing_uji.revisi.bimbingUji.tugas_akhir.mahasiswa'])->findOrFail($sidang->id);
        $bimbingUjis = $jdwl->tugas_akhir->bimbing_uji->filter(function ($item) use ($jdwl) {
            return !($item->jenis == 'penguji' && $jdwl->tugas_akhir->bimbing_uji()->where('jenis', 'pengganti')->where('urut', $item->urut)->count() > 0);
        })->sortBy('urut')->sortBy('jenis')->values();

        $query = $bimbingUjis->map(function ($bimbingUji) {
            $nilaiSeminar = $bimbingUji->penilaian->filter(function ($nilai) {
                return $nilai->type == 'Sidang';
            });
            $totalNilaiAngka = $nilaiSeminar->avg('nilai');
            $totalNilaiHuruf = grade($totalNilaiAngka);
            $peran = 'pengganti';
            if ($bimbingUji->jenis == 'pembimbing') {
                $peran = 'Pembimbing ' . toRoman($bimbingUji->urut);
            } else {
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
        $pemb1 = $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'pembimbing')->where('urut', 1)->first();
        $pemb2 = $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'pembimbing')->where('urut', 2)->first();

        $user = getInfoLogin()->userable;
        $programStudi = $user->programStudi;
        $dosen = Dosen::where('program_studi_id', $programStudi->id)->whereHas('user', function ($q) {
            $q->whereHas('roles', function ($q) {
                $q->where('name', 'Kaprodi');
            });
        })->first();
        $data = [
            'title' => 'Rekapitulasi Nilai',
            'tipe' => 'SIDANG AKHIR',
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

    public function revisionValid(Revisi $revisi)
    {
        try {
            $revisi->update(['is_valid' => true]);
            return redirect()->route('apps.jadwal-sidang')->with(['success' => 'Berhasil memperbarui status revisi']);
        } catch (Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function mentorValidation(Revisi $revisi)
    {
        try {
            $revisi->update(['is_mentor_validation' => true]);
            return redirect()->back()->with(['success' => 'Berhasil memperbarui status revisi']);
        } catch (Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function showData(Sidang $sidang)
    {
        $query = $sidang->tugas_akhir;
        $bimbingUji = $query->bimbing_uji;
        $pembimbing1 = $bimbingUji->where('jenis', 'pembimbing')->where('urut', 1)->first();
        $pembimbing2 = $bimbingUji->where('jenis', 'pembimbing')->where('urut', 2)->first();
        $penguji1 = $bimbingUji->where('jenis', 'penguji')->where('urut', 1)->first();
        $penguji2 = $bimbingUji->where('jenis', 'penguji')->where('urut', 2)->first();
        $docPengajuan = JenisDokumen::all();

        $data = [
            'title' => 'Detail Sidang',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard'),
                ],
                [
                    'title' => 'Jadwal Seminar',
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
