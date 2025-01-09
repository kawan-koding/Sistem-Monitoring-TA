<?php

namespace App\Http\Controllers\Administrator\JadwalSeminar;

use Exception;
use Carbon\Carbon;
use App\Models\Dokumen;
use App\Models\Ruangan;
use App\Models\Mahasiswa;
use App\Models\PeriodeTa;
use App\Models\BimbingUji;
use App\Models\Pemberkasan;
use App\Models\JenisDokumen;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Models\JadwalSeminar;
use App\Models\KategoriNilai;
use App\Exports\STSemproExport;
use App\Exports\SemuaDataTaExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

class JadwalSeminarController extends Controller
{
    public function index(Request $request)
    {
        $query = [];
        $periode = $request->has('filter2') && !empty($request->filter2 && $request->filter2 != 'semua') ? [$request->filter2] : PeriodeTa::where('is_active', 1)->get()->pluck('id')->toArray();
        if (getInfoLogin()->hasRole('Admin')) {
            $query = JadwalSeminar::whereHas('tugas_akhir', function ($q) use ($periode) {
                $q->where('status', 'acc')->where('is_completed', 1)->whereIn('periode_ta_id', $periode);
            });

            if ($request->has('tanggal') && !empty($request->tanggal)) {
                $query = $query->whereDate('tanggal', $request->tanggal);
            }

            if ($request->has('filter1') && !empty($request->filter1) && $request->filter1 != 'semua') {
                $query = $query->whereHas('tugas_akhir', function ($q) use ($request) {
                    $q->whereHas('mahasiswa', function ($q) use ($request) {
                        $q->where('program_studi_id', $request->filter1);
                    });
                });
            }

            if($request->has('type') && !empty($request->type) && $request->type != 'semua') {
                $query = $query->wherehas('tugas_akhir', function ($q) use ($request) {
                    $q->whereTipe($request->type);
                });
            }

            if ($request->has('status') && !empty($request->status)) {
                $query = $query->where('status', $request->status)->whereHas('tugas_akhir', function ($q) use ($request) {
                    $q->where('status_pemberkasan', 'belum_lengkap');
                });
            } else {
                if ($request->has('status_pemberkasan') && !empty($request->status_pemberkasan)) {
                    if ($request->status_pemberkasan == 'sudah_lengkap') {
                        $query = $query->whereHas('tugas_akhir', function ($q) use ($request) {
                            $q->whereNotNull('status_sidang');
                            $q->orWhereNull('status_sidang')->whereNotNull('status_seminar')->where('status_pemberkasan', 'sudah_lengkap');
                        });
                    } else {
                        $query = $query->whereHas('tugas_akhir', function ($q) use ($request) {
                            $q->whereNull('status_sidang')->where('status_pemberkasan', $request->status_pemberkasan);
                        });
                    }
                } else {
                    $query = $query->where('status', 'belum_terjadwal');
                }
            }

            if ($request->has('programStudi') && !empty($request->program_studi)) {
                $query = $query->whereHas('tugas_akhir', function ($q) use ($request) {
                    $q->whereHas('mahasiswa', function ($q) use ($request) {
                        $q->where('program_studi_id', $request->program_studi);
                    });
                });
            }

            $query = $query->get();

            $query = $query->map(function ($item) {
                $jenisDocument = JenisDokumen::whereIn('jenis', ['seminar', 'pra_seminar'])->count();
                $jenisDocumentComplete = JenisDokumen::whereIn('jenis', ['seminar', 'pra_seminar'])->whereHas('pemberkasan', function ($q) use ($item) {
                    $q->where('tugas_akhir_id', $item->tugas_akhir->id);
                })->count();
                $item->document_complete = $jenisDocument - $jenisDocumentComplete == 0;

                return $item;
            });
        }

        if (getInfoLogin()->hasRole('Mahasiswa')) {
            $myId = getInfoLogin()->userable;
            $mahasiswa = Mahasiswa::where('id', $myId->id)->first();
            if ($mahasiswa) {
                $query = JadwalSeminar::whereHas('tugas_akhir', function ($q) use ($periode, $mahasiswa) {
                    $q->whereIn('periode_ta_id', $periode)->where('mahasiswa_id', $mahasiswa->id);
                })->get();
            }
        }

        $docSeminar = JenisDokumen::whereIn('jenis', ['seminar', 'pra_seminar'])->get();
        $data = [
            'title' =>  'Jadwal Seminar',
            'mods' => 'jadwal_seminar',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Jadwal Seminar',
                    'is_active' => true,
                ]
            ],
            'data' => $query,
            'periodes' => $request->has('filter1') && $request->filter1 != 'semua' ? PeriodeTa::where('program_studi_id', $request->filter1)->get() : PeriodeTa::whereIsActive(true)->get(),
            'programStudies' => ProgramStudi::all(),
            'periode' => $periode,
            'status' => $request->has('status') ? $request->status : null,
            'status_pemberkasan' => $request->has('status_pemberkasan') ? $request->status_pemberkasan : null,
            'document_seminar' => $docSeminar,
            'filter1' => $request->has('filter1') ? $request->filter1 : null,
            'filter2' => $request->has('filter2') ? $request->filter2 : null,
            'prodi' => ProgramStudi::all(),
            'type' => $request->has('type') ? $request->type : null,
        ];

        return view('administrator.jadwal-seminar.index', $data);
    }


    public function edit(JadwalSeminar $jadwalSeminar)
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

        $data = [
            'title' => 'Jadwal Seminar',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard'),
                ],
                [
                    'title' => 'Jadwal Seminar',
                    'is_active' => true,
                ]
            ],
            'jadwalSeminar' => $jadwalSeminar,
            'ruangan' => Ruangan::all(),
            'editedData' => $jadwalSeminar,
            'jadwalPembimbing1' => JadwalSeminar::whereHas('tugas_akhir', function ($query) use ($jadwalSeminar) {
                $query->whereHas('bimbing_uji', function ($query) use ($jadwalSeminar) {
                    $dosenId = $jadwalSeminar->tugas_akhir->bimbing_uji()->where('jenis', 'pembimbing')->where('urut', 1)->first();
                    $dosenId = is_null($dosenId) ? null : $dosenId->dosen_id;

                    if (is_null($dosenId)) {
                        $query->whereNull('dosen_id');
                    } else {
                        $query->where('dosen_id', $dosenId);
                    }
                });
            })->whereDate('tanggal', '>=', Carbon::today()->format('Y-m-d'))->whereNot('id', $jadwalSeminar->id)->where('status', 'sudah_terjadwal')->orderBy('jam_mulai', 'asc')->orderBy('tanggal', 'asc')->get(),
            'jadwalPembimbing2' => JadwalSeminar::whereHas('tugas_akhir', function ($query) use ($jadwalSeminar) {
                $query->whereHas('bimbing_uji', function ($query) use ($jadwalSeminar) {
                    $dosenId = $jadwalSeminar->tugas_akhir->bimbing_uji()->where('jenis', 'pembimbing')->where('urut', 2)->first();
                    $dosenId = is_null($dosenId) ? null : $dosenId->dosen_id;

                    if (is_null($dosenId)) {
                        $query->whereNull('dosen_id');
                    } else {
                        $query->where('dosen_id', $dosenId);
                    }
                });
            })->whereDate('tanggal', '>=', Carbon::today()->format('Y-m-d'))->whereNot('id', $jadwalSeminar->id)->where('status', 'sudah_terjadwal')->get(),
            'jadwalPenguji1' => JadwalSeminar::whereHas('tugas_akhir', function ($query) use ($jadwalSeminar) {
                $query->whereHas('bimbing_uji', function ($query) use ($jadwalSeminar) {
                    $dosenId = $jadwalSeminar->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', 1)->first();
                    $dosenId = is_null($dosenId) ? null : $dosenId->dosen_id;

                    if (is_null($dosenId)) {
                        $query->whereNull('dosen_id');
                    } else {
                        $query->where('dosen_id', $dosenId);
                    }
                });
            })->whereDate('tanggal', '>=', Carbon::today()->format('Y-m-d'))->whereNot('id', $jadwalSeminar->id)->where('status', 'sudah_terjadwal')->orderBy('jam_mulai', 'asc')->orderBy('tanggal', 'asc')->get(),
            'jadwalPenguji2' => JadwalSeminar::whereHas('tugas_akhir', function ($query) use ($jadwalSeminar) {
                $query->whereHas('bimbing_uji', function ($query) use ($jadwalSeminar) {
                    $dosenId = $jadwalSeminar->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', 2)->first();
                    $dosenId = is_null($dosenId) ? null : $dosenId->dosen_id;

                    if (is_null($dosenId)) {
                        $query->whereNull('dosen_id');
                    } else {
                        $query->where('dosen_id', $dosenId);
                    }
                });
            })->whereDate('tanggal', '>=', Carbon::today()->format('Y-m-d'))->whereNot('id', $jadwalSeminar->id)->where('status', 'sudah_terjadwal')->orderBy('jam_mulai', 'asc')->orderBy('tanggal', 'asc')->get(),
            'mahasiswaTerdaftar' => JadwalSeminar::where('status', 'sudah_terjadwal')->whereIn('tanggal', $currentWeekDays)->orderBy('jam_mulai', 'asc')->orderBy('tanggal', 'asc')->get(),
        ];

        // dd($data);
        return view('administrator.jadwal-seminar.form', $data);
    }

    public function update(Request $request, JadwalSeminar $jadwalSeminar)
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
            // dd($request->tanggal);
            $periode = PeriodeTa::where('is_active', 1)->where('program_studi_id', $jadwalSeminar->tugas_akhir->mahasiswa->program_studi_id)->first();
            if (!is_null($periode) && Carbon::createFromFormat('Y-m-d', $request->tanggal)->greaterThan(Carbon::parse($periode->akhir_seminar))) {
                return redirect()->back()->with(['error' => 'Jadwal seminar melebihi batas periode']);
            }
            if (!is_null($periode) && !Carbon::createFromFormat('Y-m-d', $request->tanggal)->greaterThan(Carbon::parse($periode->mulai_seminar))) {
                return redirect()->back()->with(['error' => 'Periode seminar belum aktif']);
            }

            $check = JadwalSeminar::whereNot('id', $jadwalSeminar->id)->whereHas('tugas_akhir', function($q) use ($jadwalSeminar) {
                $q->whereHas('bimbing_uji', function($q) use ($jadwalSeminar) {
                    $q->whereIn('dosen_id', $jadwalSeminar->tugas_akhir->bimbing_uji()->pluck('dosen_id')->toArray());
                });
            })->whereDate('tanggal', $request->tanggal)->where('jam_mulai', '<=', $request->jam_mulai)->where('jam_selesai', '>=', $request->jam_mulai)->first();

            $checkRuangan = JadwalSeminar::whereNot('id', $jadwalSeminar->id)->whereRuanganId($request->ruangan)->whereDate('tanggal', $request->tanggal)->where('jam_mulai', '>', $request->jam_mulai)->where('jam_selesai', '<', $request->jam_selesai)->first();

            if (!is_null($check)) {
                return redirect()->back()->withInput($request->all())->with(['error' => 'Ada jadwal pada waktu tersebut']);
            }
            if(!is_null($checkRuangan)) {
                return redirect()->back()->withInput($request->all())->with(['error' => 'Ruangan sudah digunakan pada waktu tersebut']);
            }

            $jadwalSeminar->update([
                'ruangan_id' => $request->ruangan,
                'tanggal' => $request->tanggal,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'status' => 'sudah_terjadwal'
            ]);
            $jadwalSeminar->tugas_akhir->update(['status_seminar' => null]);
            return redirect()->route('apps.jadwal-seminar')->with(['success' => 'Berhasil menyimpan data']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function detail(JadwalSeminar $jadwalSeminar)
    {
        $recapPemb1 = $jadwalSeminar->tugas_akhir->bimbing_uji()->where('jenis', 'pembimbing')->where('urut', 1)->first()->penilaian()->where('type', 'Seminar')->sum('nilai');
        $recapPemb1 = $recapPemb1 > 0 ? $recapPemb1 / $jadwalSeminar->tugas_akhir->bimbing_uji()->where('jenis', 'pembimbing')->where('urut', 1)->first()->penilaian()->where('type', 'Seminar')->count() : 0;
        $recapPemb2 = $jadwalSeminar->tugas_akhir->bimbing_uji()->where('jenis', 'pembimbing')->where('urut', 2)->first()->penilaian()->where('type', 'Seminar')->sum('nilai');
        $recapPemb2 = $recapPemb2 > 0 ? $recapPemb2 / $jadwalSeminar->tugas_akhir->bimbing_uji()->where('jenis', 'pembimbing')->where('urut', 2)->first()->penilaian()->where('type', 'Seminar')->count() : 0;
        $recapPenguji1 = $jadwalSeminar->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', 1)->first()->penilaian()->where('type', 'Seminar')->sum('nilai');
        $recapPenguji1 = $recapPenguji1 > 0 ? $recapPenguji1 / $jadwalSeminar->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', 1)->first()->penilaian()->where('type', 'Seminar')->count() : 0;
        $recapPenguji2 = $jadwalSeminar->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', 2)->first()->penilaian()->where('type', 'Seminar')->sum('nilai');
        $recapPenguji2 = $recapPenguji2 > 0 ? $recapPenguji2 / $jadwalSeminar->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', 2)->first()->penilaian()->where('type', 'Seminar')->count() : 0;

        $nearestSchedule = [];
        $currentDate = Carbon::now();
        while (count($nearestSchedule) < 5) {
            if ($currentDate->isWeekday()) {
                $nearestSchedule[] = $currentDate->format('d-m-Y');
            }
            $currentDate->addDay();
        }

        $data = [
            'title' => 'Jadwal Seminar',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard'),
                ],
                [
                    'title' => 'Jadwal Seminar',
                    'url' => route('apps.jadwal-seminar'),
                ],
                [
                    'title' => 'Detail',
                    'is_active' => true
                ]
            ],
            'data' => $jadwalSeminar,
            'kategoriNilais' => KategoriNilai::all(),
            'bimbingUjis' => $jadwalSeminar->tugas_akhir->bimbing_uji()->orderBy('jenis', 'desc')->orderBy('urut', 'asc')->get(),
            'recapPemb1' => $recapPemb1,
            'recapPemb2' => $recapPemb2,
            'recapPenguji1' => $recapPenguji1,
            'recapPenguji2' => $recapPenguji2
        ];

        return view('administrator.jadwal-seminar.detail', $data);
    }

    public function uploadDocument(JadwalSeminar $jadwalSeminar, Request $request)
    {
        try {
            $documentTypes = JenisDokumen::all();
            $validates = [];
            $messages = [];
            $inserts = [];
            foreach ($documentTypes as $item) {
                if ($jadwalSeminar->status == 'belum_terjadwal') {
                    if ($item->jenis == 'pra_seminar') {
                        $validates['document_' . $item->id] = $item->tipe_dokumen == 'pdf' ? '|mimes:pdf|max:' . $item->max_ukuran : 'mimes:png,jpg,jpeg,webp|max:' . $item->max_ukuran;
                        $messages['document_' . $item->id . '.mimes'] = 'Dokumen ' . strtolower($item->nama) . ' harus dalam format ' . ($item->tipe_dokumen == 'pdf' ? 'PDF' : 'PNG, JPEG, JPG, WEBP');
                        $messages['document_' . $item->id . '.max'] = 'Dokumen ' . strtolower($item->nama) . ' tidak boleh lebih dari ' . $item->max_ukuran . ' KB';
                    }
                } else {
                    if ($item->jenis == 'seminar') {
                        $validates['document_' . $item->id] = $item->tipe_dokumen == 'pdf' ? '|mimes:pdf|max:' . $item->max_ukuran : 'mimes:png,jpg,jpeg,webp|max:' . $item->max_ukuran;
                        $messages['document_' . $item->id . '.mimes'] = 'Dokumen ' . strtolower($item->nama) . ' harus dalam format ' . ($item->tipe_dokumen == 'pdf' ? 'PDF' : 'PNG, JPEG, JPG, WEBP');
                        $messages['document_' . $item->id . '.max'] = 'Dokumen ' . strtolower($item->nama) . ' tidak boleh lebih dari ' . $item->max_ukuran . ' KB';
                    }
                }
            }

            $request->validate($validates, $messages);

            foreach ($documentTypes as $item) {
                if (($item->jenis == 'pra_seminar' || $item->jenis == 'seminar') && $request->hasFile('document_' . $item->id)) {
                    $file = $request->file('document_' . $item->id);
                    $filename = 'document_' . rand(0, 999999999) . '_' . rand(0, 999999999) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('storage/files/pemberkasan'), $filename);

                    $document = $item->pemberkasan()->where('tugas_akhir_id', $jadwalSeminar->tugas_akhir->id)->where('jenis_dokumen_id', $item->id)->first();
                    if ($document) {
                        File::delete(public_path('storage/files/pemberkasan/' . $document->filename));

                        $document->update([
                            'filename' => $filename
                        ]);
                    } else {
                        $inserts[] = [
                            'tugas_akhir_id' => $jadwalSeminar->tugas_akhir->id,
                            'jenis_dokumen_id' => $item->id,
                            'filename' => $filename,
                            'updated_at' => now(),
                            'created_at' => now()
                        ];
                    }
                }
            }

            if (count($inserts) > 0) {
                Pemberkasan::insert($inserts);
            }

            return redirect()->back()->with(['success' => 'Dokumen berhasil ditambahkan']);
        } catch (Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function show(JadwalSeminar $jadwalSeminar)
    {
        $query = $jadwalSeminar->tugas_akhir;
        $bimbingUji = $query->bimbing_uji;
        $pembimbing1 = $bimbingUji->where('jenis', 'pembimbing')->where('urut', 1)->first();
        $pembimbing2 = $bimbingUji->where('jenis', 'pembimbing')->where('urut', 2)->first();
        $penguji1 = $bimbingUji->where('jenis', 'penguji')->where('urut', 1)->first();
        $penguji2 = $bimbingUji->where('jenis', 'penguji')->where('urut', 2)->first();
        $docPengajuan = JenisDokumen::all();

        $data = [
            'title' => 'Detail Jadwal Seminar',
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

    public function validasiBerkas(JadwalSeminar $jadwalSeminar)
    {
        try {
            $jadwalSeminar->tugas_akhir()->update(['status_pemberkasan' => 'sudah_lengkap']);

            return redirect()->back()->with(['success' => 'Berkas berhasil diperbarui']);
        } catch (Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }


    public function export(Request $request)
    {
        $status = $request->input('type');
        $title = '';
        $export = null;

        switch ($status) {
            case 'st_sempro':
                $export = new STSemproExport();
                $title = 'ST SEMPRO';
                break;

            case 'belum_terjadwal':
                $export = new SemuaDataTaExport($status);
                $title = 'Belum Terjadwal Sempro';
                break;

            case 'sudah_terjadwal':
                $export = new SemuaDataTaExport($status);
                $title = 'Sudah Terjadwal Sempro';
                break;

            case 'telah_seminar':
                $export = new SemuaDataTaExport($status);
                $title = 'Telah Diseminarkan';
                break;

            case 'sudah_pemberkasan':
                $export = new SemuaDataTaExport($status);
                $title = 'Sudah Pemberkasan Seminar';
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


    public function reset(Request $request, JadwalSeminar $jadwalSeminar)
    {
        try {$jadwalSeminar->update([
                'ruangan_id' => null,
                'tanggal' => null,
                'jam_mulai' => null,
                'jam_selesai' => null,
                'status' => 'belum_terjadwal'
            ]);

            return redirect()->route('apps.jadwal-seminar')->with(['success' => 'Berhasil mereset jadwal seminar']);
        } catch (Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
}
