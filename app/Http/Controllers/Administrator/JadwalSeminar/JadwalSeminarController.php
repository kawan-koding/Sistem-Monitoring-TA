<?php

namespace App\Http\Controllers\Administrator\JadwalSeminar;

use App\Http\Controllers\Controller;
use App\Models\Dokumen;
use App\Models\JadwalSeminar;
use App\Models\JenisDokumen;
use App\Models\KategoriNilai;
use App\Models\Mahasiswa;
use App\Models\Pemberkasan;
use App\Models\PeriodeTa;
use App\Models\Ruangan;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class JadwalSeminarController extends Controller
{
    public function index(Request $request)
    {
        $query = [];
        $periode = PeriodeTa::where('is_active', 1)->first();
        if(getInfoLogin()->hasRole('Admin')) {
            $query = JadwalSeminar::whereHas('tugas_akhir', function ($q) use($periode) { 
                $q->where('status', 'acc')->where('periode_ta_id', $periode->id); 
            });

            if($request->has('tanggal') && !empty($request->tanggal)) {
                $query = $query->whereDate('tanggal', $request->tanggal);
            }

            if($request->has('status') && !empty($request->status)) {
                $query = $query->where('status', $request->status);
            } else {
                $query = $query->where('status', 'belum_terjadwal');
            }
            $query = $query->get();

            $query = $query->map(function($item) {
                $jenisDocument = JenisDokumen::whereIn('jenis', ['seminar', 'pra_seminar'])->count();
                $jenisDocumentComplete = JenisDokumen::whereIn('jenis', ['seminar', 'pra_seminar'])->whereHas('pemberkasan', function($q) use ($item) {
                    $q->where('tugas_akhir_id', $item->tugas_akhir->id);
                })->count();
                $item->document_complete = $jenisDocument - $jenisDocumentComplete == 0;

                return $item;
            });
        }
        if(getInfoLogin()->hasRole('Mahasiswa')) {
            $myId = getInfoLogin()->userable;
            $mahasiswa = Mahasiswa::where('id', $myId->id)->first();
            if($mahasiswa) {
                $query = JadwalSeminar::whereHas('tugas_akhir', function ($q) use($periode, $mahasiswa) {
                    $q->where('periode_ta_id', $periode->id)->where('mahasiswa_id', $mahasiswa->id);
                })->get();
            }
        }

        $docSeminar = JenisDokumen::whereIn('jenis', ['seminar', 'pra_seminar'])->get();
        // $doc = Pemberkasan::where('jenis_dokumen_id', $docSeminar[0]->id)->get();
        $data = [
            'title' =>  'Jadwal Seminar',
            'breadcrumbs' =>[
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
            'status' => $request->has('status') ? $request->status : null,
            'document_seminar' => $docSeminar,
            // 'doc' => $doc->count() > 0 ? $doc[0] : collect([]),
            // 'documents' => $query->count() > 0 ? Dokumen::where('model_type', JadwalSeminar::class)->where('model_id', $query[0]->id)->get() : collect([]), 
        ];
        
        return view('administrator.jadwal-seminar.index', $data);
    }


    public function edit(JadwalSeminar $jadwalSeminar)
    {
        $data = [
            'title' => 'Jadwal Seminar',
            'breadcrumbs' =>[
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

                    if(is_null($dosenId)) {
                        $query->whereNull('dosen_id');
                    } else {
                        $query->where('dosen_id', $dosenId);
                    }
                    $query->where('jenis', 'pembimbing')->where('urut', 1);
                });
            })->where('status', 'sudah_terjadwal')->get(),
            'jadwalPembimbing2' => JadwalSeminar::whereHas('tugas_akhir', function ($query) use ($jadwalSeminar) {
                $query->whereHas('bimbing_uji', function ($query) use ($jadwalSeminar) {
                    $dosenId = $jadwalSeminar->tugas_akhir->bimbing_uji()->where('jenis', 'pembimbing')->where('urut', 2)->first();
                    $dosenId = is_null($dosenId) ? null : $dosenId->dosen_id;

                    if(is_null($dosenId)) {
                        $query->whereNull('dosen_id');
                    } else {
                        $query->where('dosen_id', $dosenId);
                    }
                    $query->where('jenis', 'pembimbing')->where('urut', 2);
                });
            })->where('status', 'sudah_terjadwal')->get(),
            'jadwalPenguji1' => JadwalSeminar::whereHas('tugas_akhir', function ($query) use ($jadwalSeminar) {
                $query->whereHas('bimbing_uji', function ($query) use ($jadwalSeminar) {
                    $dosenId = $jadwalSeminar->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', 1)->first();
                    $dosenId = is_null($dosenId) ? null : $dosenId->dosen_id;

                    if(is_null($dosenId)) {
                        $query->whereNull('dosen_id');
                    } else {
                        $query->where('dosen_id', $dosenId);
                    }
                    $query->where('jenis', 'penguji')->where('urut', 1);
                });
            })->where('status', 'sudah_terjadwal')->get(),
            'jadwalPenguji2' => JadwalSeminar::whereHas('tugas_akhir', function ($query) use ($jadwalSeminar) {
                $query->whereHas('bimbing_uji', function ($query) use ($jadwalSeminar) {
                    $dosenId = $jadwalSeminar->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', 2)->first();
                    $dosenId = is_null($dosenId) ? null : $dosenId->dosen_id;

                    if(is_null($dosenId)) {
                        $query->whereNull('dosen_id');
                    } else {
                        $query->where('dosen_id', $dosenId);
                    }
                    $query->where('jenis', 'penguji')->where('urut', 2);
                });
            })->where('status', 'sudah_terjadwal')->get(),
            
        ];

        // dd($data);
        return view('administrator.jadwal-seminar.form', $data);
    }

    public function update(Request $request, JadwalSeminar $jadwalSeminar) 
    {
        $request->validate([
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
        ]);
        try {
            // dd($request->tanggal);
            $periode = PeriodeTa::where('is_active', 1)->first();
            if(!is_null($periode) && Carbon::createFromFormat('Y-m-d',$request->tanggal)->greaterThan(Carbon::parse($periode->akhir_seminar))){
                return redirect()->back()->with(['error' => 'Jadwal seminar melebihi batas periode']);
            }
            if(!is_null($periode) && !Carbon::createFromFormat('Y-m-d', $request->tanggal)->greaterThan(Carbon::parse($periode->mulai_seminar))){
                return redirect()->back()->with(['error' => 'Periode seminar belum aktif']);
            }

            $check = JadwalSeminar::whereRuanganId($request->ruangan)->whereDate('tanggal', $request->tanggal)->where('jam_mulai', '>=', $request->jam_mulai)->where('jam_selesai', '<=', $request->jam_selesai)->first();

            if(!is_null($check)) {
                return redirect()->back()->with(['error' => 'Jadwal ini sudah ada']);
            }

            $jadwalSeminar->update([
                'ruangan_id' => $request->ruangan,
                'tanggal' => $request->tanggal,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'status' => 'sudah_terjadwal'
            ]);
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

    public function uploadDocument(JadwalSeminar $jadwalSeminar, Request $request) {
        try {
            $documentTypes = JenisDokumen::all();
            $validates = [];
            $messages = [];
            $inserts = [];
            foreach($documentTypes as $item) {
                if($jadwalSeminar->status == 'belum_terjadwal') {
                    if($item->jenis == 'pra_seminar') {
                        $validates['document_'. $item->id] = '|mimes:pdf|max:2048';
                        $messages['document_'. $item->id .'.mimes'] = 'Dokumen '. strtolower($item->nama) .' harus dalam format PDF';
                        $messages['document_'. $item->id .'.max'] = 'Dokumen '. strtolower($item->nama) .' tidak boleh lebih dari 2 MB';
                    }
                } else {
                    if($item->jenis == 'seminar') {
                        $validates['document_'. $item->id] = '|mimes:pdf|max:2048';
                        $messages['document_'. $item->id .'.mimes'] = 'Dokumen '. strtolower($item->nama) .' harus dalam format PDF';
                        $messages['document_'. $item->id .'.max'] = 'Dokumen '. strtolower($item->nama) .' tidak boleh lebih dari 2 MB';
                    }
                }
            }
            
            // dd($validates);
            $request->validate($validates, $messages);
            // dd($request->all());
            
            foreach($documentTypes as $item) {
                if($jadwalSeminar->status == 'belum_terjadwal') {
                    if($item->jenis == 'pra_seminar' && $request->hasFile('document_'. $item->id)) {
                        $file = $request->file('document_'. $item->id);
                        $filename = 'document_'. rand(0, 999999999) .'_'. rand(0, 999999999) .'.'. $file->getClientOriginalExtension();
                        $file->move(public_path('storage/files/pemberkasan'), $filename);
    
                        $document = $item->pemberkasan()->where('tugas_akhir_id', $jadwalSeminar->tugas_akhir->id)->first();
                        if($document) {
                            File::delete(public_path('storage/files/pemberkasan/'. $document->filename));
    
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
                } else {
                    if($item->jenis == 'seminar' && $request->hasFile('document_'. $item->id)) {
                        $file = $request->file('document_'. $item->id);
                        $filename = 'document_'. rand(0, 999999999) .'_'. rand(0, 999999999) .'.'. $file->getClientOriginalExtension();
                        $file->move(public_path('storage/files/pemberkasan'), $filename);
    
                        $document = $item->pemberkasan()->where('tugas_akhir_id', $jadwalSeminar->tugas_akhir->id)->first();
                        if($document) {
                            File::delete(public_path('storage/files/pemberkasan/'. $document->filename));
    
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
            }

            if(count($inserts) > 0) {
                Pemberkasan::insert($inserts);
            }

            return redirect()->back()->with(['success' => 'Dokumen berhasil ditambahkan']);
        } catch(Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
}
