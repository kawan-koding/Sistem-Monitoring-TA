<?php

namespace App\Http\Controllers\Administrator\DaftarTA;

use File;
use App\Models\Dosen;
use App\Models\Topik;
use App\Models\JenisTa;
use App\Models\PeriodeTa;
use App\Models\BimbingUji;
use App\Models\KuotaDosen;
use App\Models\TugasAkhir;
use App\Models\Pemberkasan;
use App\Models\JenisDokumen;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Exports\TugasAkhirExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class DaftarTAController extends Controller
{
    public function index(Request $request)
    {
        $periode = PeriodeTa::where('is_active', 1)->get();
        $periode = $request->has('periode') && !empty($request->periode && $request->periode != 'semua') ? $request->periode : $periode;

        $dataTa = TugasAkhir::with(['mahasiswa','bimbing_uji','periode_ta','topik','jenis_ta']);
        if ($request->has('periode') && !empty($request->periode) && $request->periode != 'semua') {
            $dataTa->where('periode_ta_id', $request->periode);
        } else {
            $dataTa->whereIn('periode_ta_id', $periode->pluck('id'));
        }

        if (session('switchRoles') == 'Kaprodi') {
            $user = getInfoLogin()->userable;
            $prodi = $user->programStudi->id;
            if($prodi) {
                $dataTa->where('status', 'acc')->whereHas('mahasiswa', function($query) use ($prodi) {
                    $query->where('program_studi_id', $prodi);
                });
            } else {
                $dataTa->where('status', 'acc');
            }
        }

        if ($request->has('program_studi') && !empty($request->program_studi) && $request->program_studi !== 'semua') {
            $dataTa->whereHas('mahasiswa', function($query) use ($request) {
                $query->where('program_studi_id', $request->program_studi);
            });
        }
        
        $dataTa = $dataTa->get();

        $periode = PeriodeTa::query();
        if ($request->has('program_studi') && !empty($request->program_studi) && $request->program_studi !== 'semua') {
            $periode->where('program_studi_id', $request->program_studi);
        }
        $periode = $periode->whereIsActive(true)->get();

        $data = [
            'title' => 'Daftar Tugas Akhir',
            'mods' => 'daftar_ta',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Tugas Akhir',
                    'is_active' => true
                ],
                [
                    'title' => 'Daftar Tugas Akhir',
                    'is_active' => true
                ]
            ],
            'data' => $dataTa,
            'prodi' => ProgramStudi::all(),
            'periode' => $periode,
            'periodes' => $request->has('filter1') && $request->filter1 != 'semua' ? PeriodeTa::where('program_studi_id', $request->filter1)->get() : PeriodeTa::whereIsActive(true)->get(),

        ];
        
        return view('administrator.daftar-ta.index', $data);
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
                    'title' => 'Tugas Akhir',
                    'is_active' => true
                ],
                [
                    'title' => 'Daftar Tugas Akhir',
                    'url' => route('apps.daftar-ta')
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

    public function edit(TugasAkhir $tugasAkhir)
    {
        $remapped = clone $tugasAkhir; 
        $remapped->load('mahasiswa','bimbing_uji','periode_ta','topik','jenis_ta');
        $pemb1 = $remapped->bimbing_uji()->where('urut', 1)->where('jenis','pembimbing')->first();
        $pemb2 = $remapped->bimbing_uji()->where('urut', 2)->where('jenis','pembimbing')->first();
        $peng1 = $remapped->bimbing_uji()->where('urut', 1)->where('jenis','penguji')->first();
        $peng2 = $remapped->bimbing_uji()->where('urut', 2)->where('jenis','penguji')->first();

        $bimbingUji = $tugasAkhir->bimbing_uji;
        $pembimbing = $bimbingUji->where('jenis', 'pembimbing')->sortBy('urut')->values();
        $penguji = $bimbingUji->where('jenis', 'penguji')->sortBy('urut')->values();
        $prodi = $tugasAkhir->mahasiswa->program_studi_id;
        $periode = PeriodeTa::where('is_active', true)->where('program_studi_id', $prodi)->first();
        $dosen = Dosen::all()->map(function($dosen) use ($periode) {
            $kuota = KuotaDosen::where('dosen_id', $dosen->id)->where('periode_ta_id', $periode->id)->first();
            $totalPembimbing1 = BimbingUji::where('dosen_id', $dosen->id)->where('jenis', 'pembimbing')->where('urut', 1)->whereHas('tugas_akhir', function($query) use ($periode) {
                                    $query->where('periode_ta_id', $periode->id)->whereNotIn('status', ['reject', 'cancel']);
                                })->count();
            $totalPembimbing2 = BimbingUji::where('dosen_id', $dosen->id)->where('jenis', 'pembimbing')->where('urut', 2)->whereHas('tugas_akhir', function($query) use ($periode) {
                                    $query->where('periode_ta_id', $periode->id)->whereNotIn('status', ['reject', 'cancel']);
                                })->count();
            $totalPenguji1 = BimbingUji::where('dosen_id', $dosen->id)->where('jenis', 'penguji')->where('urut', 1)->whereHas('tugas_akhir', function($query) use ($periode) {
                                $query->where('periode_ta_id', $periode->id)->whereNotIn('status', ['reject', 'cancel']);
                            })->count();
            $totalPenguji2 = BimbingUji::where('dosen_id', $dosen->id)->where('jenis', 'penguji')->where('urut', 2)->whereHas('tugas_akhir', function($query) use ($periode) {
                                $query->where('periode_ta_id', $periode->id)->whereNotIn('status', ['reject', 'cancel']);
                            })->count();
            return (object)[
                'id' => $dosen->id,
                'nama' => $dosen->name,
                'kuota_pemb_1' => $kuota->pembimbing_1 ?? 0,
                'kuota_pemb_2' => $kuota->pembimbing_2 ?? 0,
                'kuota_peng_1' => $kuota->penguji_1 ?? 0,
                'kuota_peng_2' => $kuota->penguji_2 ?? 0,
                'total_pemb_1' => $totalPembimbing1,
                'total_pemb_2' => $totalPembimbing2,
                'total_peng_1' => $totalPenguji1,
                'total_peng_2' => $totalPenguji2,
                'sisa_pemb_1' => max(0, ($kuota->pembimbing_1 ?? 0) - $totalPembimbing1),
                'sisa_pemb_2' => max(0, ($kuota->pembimbing_2 ?? 0) - $totalPembimbing2),
                'sisa_peng_1' => max(0, ($kuota->penguji_1 ?? 0) - $totalPenguji1),
                'sisa_peng_2' => max(0, ($kuota->penguji_2 ?? 0) - $totalPenguji2),
            ];
        });

        $docPengajuan = JenisDokumen::where('jenis','pendaftaran')->get();
        $data = [
            'title' => 'Edit Tugas Akhir',
            'mods' => 'daftar_ta',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Tugas Akhir',
                    'is_active' => true
                ],
                [
                    'title' => 'Daftar Tugas Akhir',
                    'url' => route('apps.daftar-ta')
                ],
                [
                    'title' => 'Edit Tugas Akhir',
                    'is_active' => true
                ]
            ],
            'pembimbing' => $pembimbing,
            'penguji' => $penguji,
            'dosen' => $dosen,
            'data' => $remapped,
            'pemb1' => $pemb1,
            'pemb2' => $pemb2,
            'peng1' => $peng1,
            'peng2' => $peng2,
            'jenis' => JenisTa::all(),
            'topik' => Topik::all(),
            'editedData' => $tugasAkhir,
            'doc' => $docPengajuan,
            'action' => route('apps.daftar-ta.update', $tugasAkhir->id),
        ];
        
        return view('administrator.daftar-ta.form', $data);
    }

    public function update(Request $request, TugasAkhir $tugasAkhir)
    {
        $request->validate([
            'judul' => 'required',
            'pembimbing_1' => 'required',
            'pembimbing_2' => 'required',
            'penguji_1' => 'required',
            'penguji_2' => 'required',
            'jenis_ta_id' => 'required',
            'topik_id' => 'required',
            'tipe' => 'required',
            'doc_pemb_1' => 'nullable|mimes:pdf,docx,doc|max:5120',
            'doc_ringkasan' => 'nullable|mimes:docx,pdf|max:5120',
            'topik_ta_new' => 'nullable',
            'jenis_ta_new' => 'nullable',
        ],[
            'judul' => 'Judul Tugas Akhir harus diisi.',
            'pembimbing_1' => 'Pembimbing 1 harus diisi.',
            'pembimbing_2' => 'Pembimbing 2 harus diisi.',
            'penguji_1' => 'Penguji 1 harus diisi.',
            'penguji_2' => 'Penguji 2 harus diisi.',
            'jenis_ta.required' => 'Jenis Tugas Akhir harus diisi.',
            'topik.required' => 'Topik harus diisi.',
            'tipe.required' => 'Tipe harus diisi.',
            'doc_ringkasan.max' => 'Dokumen ringkasan maksimal 5 MB.',
            'doc_pemb_1.max' => 'Dokumen pembimbing 1 maksimal 5 MB.',
            'doc_pemb_1.mimes' => 'Dokumen pembimbing 1 harus dalam format PDF atau DOCX.',
            'doc_ringkasan.mimes' => 'Dokumen ringkasan harus dalam format PDF atau DOCX.',
        ]);
        
        try {
            $kuota = KuotaDosen::where('dosen_id', $request->pembimbing_1)->where('periode_ta_id', $tugasAkhir->periode_ta_id)->first();
            $validasiData = [
                ['tipe' => 'pembimbing', 'urut' => 1, 'dosen_id' => $request->pembimbing_1, 'kuota' => $kuota->pembimbing_1],
                ['tipe' => 'pembimbing', 'urut' => 2, 'dosen_id' => $request->pembimbing_2, 'kuota' => $kuota->pembimbing_2],
                ['tipe' => 'penguji', 'urut' => 1, 'dosen_id' => $request->penguji_1, 'kuota' => $kuota->penguji_1],
                ['tipe' => 'penguji', 'urut' => 2, 'dosen_id' => $request->penguji_2, 'kuota' => $kuota->penguji_2],
            ];

            foreach ($validasiData as $validasi) {
                $bimbingUji = BimbingUji::with(['tugas_akhir', 'dosen'])
                    ->where('jenis', $validasi['tipe'])
                    ->where('urut', $validasi['urut'])
                    ->where('dosen_id', $validasi['dosen_id'])
                    ->whereHas('tugas_akhir', function ($q) use ($tugasAkhir) {
                        $q->where('periode_ta_id', $tugasAkhir->periode_ta_id);
                    })
                    ->count();
                if ($bimbingUji >= $validasi['kuota']) {
                    return redirect()->back()->with('error', 'Kuota untuk dosen ' . $validasi['tipe'] . ' ' . $validasi['urut'] . ' telah penuh.');
                }
            }
 
            if($request->jenis_ta_new !== null) {
                $newJenis = JenisTa::create(['nama_jenis' => $request->jenis_ta_new]);
                $jenis = $newJenis->id;
            } else {
                $jenis = $request->jenis_ta_id;
            }

            if($request->topik_ta_new !== null) {
                $newTopik = Topik::create(['nama_topik' => $request->topik_ta_new]);
                $topik = $newTopik->id;
            } else {
                $topik = $request->topik_id;
            }

            $request->merge(['jenis_ta_id' => $jenis, 'topik_id' => $topik]);
            $tugasAkhir->update($request->only(['jenis_ta_id', 'topik_id', 'judul', 'tipe', 'dokumen_pemb_1', 'dokumen_ringkasan']));
            $data = [
                ['jenis' => 'pembimbing', 'urut' => 1, 'dosen_id' => $request->pembimbing_1],
                ['jenis' => 'pembimbing', 'urut' => 2, 'dosen_id' => $request->pembimbing_2],
                ['jenis' => 'penguji', 'urut' => 1, 'dosen_id' => $request->penguji_1],
                ['jenis' => 'penguji', 'urut' => 2, 'dosen_id' => $request->penguji_2],
            ];

            foreach ($data as $item) {
                BimbingUji::updateOrCreate(
                    [
                        'tugas_akhir_id' => $tugasAkhir->id,
                        'jenis' => $item['jenis'],
                        'urut' => $item['urut']
                    ],
                    ['dosen_id' => $item['dosen_id']]
                );
            }

            $docPengajuan = JenisDokumen::where('jenis','pendaftaran')->get();
            $validates = [];
            $messages = [];
            $inserts = [];

            foreach ($docPengajuan as $item) {
                $validates['document_' . $item->id] = $item->tipe_dokumen == 'pdf' ? '|mimes:pdf|max:' . $item->max_ukuran : 'mimes:png,jpg,jpeg,webp|max:' . $item->max_ukuran;
                $messages['document_' . $item->id . '.mimes'] = 'Dokumen ' . strtolower($item->nama) . ' harus dalam format ' . ($item->tipe_dokumen == 'pdf' ? 'PDF' : 'PNG, JPEG, JPG, WEBP');
                $messages['document_' . $item->id . '.max'] = 'Dokumen ' . strtolower($item->nama) . ' tidak boleh lebih dari ' . $item->max_ukuran . ' KB';
            }
            
            $request->validate($validates, $messages);

            foreach($docPengajuan as $item) {
                $file = $request->file('dokumen_'.$item->id);
                $filename = 'document_' . rand(0, 999999999) .'_'. rand(0, 999999999) .'.'. $file->getClientOriginalExtension();
                $file->move(public_path('storage/files/pemberkasan'), $filename);
                $pemberkasan = Pemberkasan::where('tugas_akhir_id', $tugasAkhir->id)->where('jenis_dokumen_id', $item->id)->first();
                if(!is_null($pemberkasan)) {
                    File::delete(public_path('Storage/files/pemberkasan/'.$pemberkasan->filename));
                    $pemberkasan->update([
                        'filename' => $filename,
                    ]);
                } else {
                    Pemberkasan::create([
                        'tugas_akhir_id' => $pengajuanTA->id,
                        'jenis_dokumen_id' => $item->id,
                        'filename' => $filename,
                    ]);
                }
            }

            return redirect()->route('apps.daftar-ta')->with('success', 'Data berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(TugasAkhir $tugasAkhir)
    {
        try {
            if($tugasAkhir->dokumen_pemb_1) {
                File::delete(public_path('storage/files/tugas-akhir/'. $tugasAkhir->dokumen_pemb_1));
            }

            if($tugasAkhir->dokumen_ringkasan) {
                File::delete(public_path('storage/files/tugas-akhir/'. $tugasAkhir->dokumen_ringkasan));
            }
            $tugasAkhir->delete();

            return $this->successResponse('Berhasi menghapus data');
        } catch(\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function exportAll(Request $request)
    {
        $prodiId = $request->query('prodi');
        $prodi = ProgramStudi::find($prodiId);
        
        if (!$prodi) {
            return redirect()->back()->with('error', 'Program studi tidak ditemukan.');
        }

        return Excel::download(new TugasAkhirExport($prodiId), "Data Tugas Akhir  - {$prodi->display} .xlsx");
    }
}
