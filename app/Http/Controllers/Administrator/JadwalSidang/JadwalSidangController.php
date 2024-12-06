<?php

namespace App\Http\Controllers\Administrator\JadwalSidang;

use Exception;
use Carbon\Carbon;
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
use Illuminate\Support\Facades\DB;
use App\Exports\SKSidangAkhirExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class JadwalSidangController extends Controller
{
    public function index(Request $request, $jenis = 'pembimbing')
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

        if(getInfoLogin()->hasRole('Dosen')) {
            $user = getInfoLogin()->userable;
            $query = BimbingUji::where('dosen_id', $user->id)->where('jenis', $jenis)->whereHas('tugas_akhir', function($q) use ($periode) {
                $q->where('periode_ta_id', $periode->id)->whereHas('sidang', function ($q) {
                    $q->whereIn('status', ['sudah_daftar', 'sudah_terjadwal', 'sudah_sidang']);
                });
            })->get();
        }

        if(getInfoLogin()->hasRole('Admin')) {
            if($request->has('tanggal') && !empty($request->tanggal)) {
                $query = $query->whereDate('tanggal', $request->tanggal);
            }

            if($request->has('status') && !empty($request->status)) {
                if($request->status == 'sudah_sidang' || $request->status == 'sudah_terjadwal') {
                    $query = $query->where('status', $request->status)->whereHas('tugas_akhir', function ($q) use($request) {
                        $q->where('status_pemberkasan', 'belum_lengkap');
                    });
                } else {
                    $query = $query->where('status', $request->status)->whereHas('tugas_akhir', function ($q) use($request) {
                        $q->whereNull('status_sidang');
                        $q->where('status_pemberkasan', 'sudah_lengkap');
                    });
                }
            } else {
                if($request->has('status_pemberkasan') && !empty($request->status_pemberkasan)) {
                    $query = $query->whereHas('tugas_akhir', function ($q) use($request) {
                        $q->whereNotNull('status_sidang');
                        $q->where('status_pemberkasan', $request->status_pemberkasan);
                    });
                } else {
                    $query = $query->where('status', 'sudah_daftar');
                }
            }
            $query = $query->get();
            
            // dd($query);

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

    public function edit(Sidang $jadwalSidang)
    {
        $currentWeekDays = [];
        $i = 0;
        
        while(count($currentWeekDays) <= 7) {
            $date = Carbon::now()->addDays($i);

            if($date->isWeekday()) {
                $currentWeekDays[] = $date->format('Y-m-d');
            }

            $i++;
        }
        // dd($jadwalSidang);
        $data = [
            'title' => 'Jadwal Sidang',
            'breadcrumbs' =>[
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

                    if(is_null($dosenId)) {
                        $query->whereNull('dosen_id');
                    } else {
                        $query->where('dosen_id', $dosenId);
                    }
                    $query->where('jenis', 'pembimbing')->where('urut', 1);
                });
            })->where('status', 'sudah_terjadwal')->get(),
            'jadwalPembimbing2' => Sidang::whereHas('tugas_akhir', function ($query) use ($jadwalSidang) {
                $query->whereHas('bimbing_uji', function ($query) use ($jadwalSidang) {
                    $dosenId = $jadwalSidang->tugas_akhir->bimbing_uji()->where('jenis', 'pembimbing')->where('urut', 2)->first();
                    $dosenId = is_null($dosenId) ? null : $dosenId->dosen_id;

                    if(is_null($dosenId)) {
                        $query->whereNull('dosen_id');
                    } else {
                        $query->where('dosen_id', $dosenId);
                    }
                    $query->where('jenis', 'pembimbing')->where('urut', 2);
                });
            })->where('status', 'sudah_terjadwal')->get(),
            'jadwalPenguji1' => Sidang::whereHas('tugas_akhir', function ($query) use ($jadwalSidang) {
                $query->whereHas('bimbing_uji', function ($query) use ($jadwalSidang) {
                    $dosenId = $jadwalSidang->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', 1)->first();
                    $dosenId = is_null($dosenId) ? null : $dosenId->dosen_id;

                    if(is_null($dosenId)) {
                        $query->whereNull('dosen_id');
                    } else {
                        $query->where('dosen_id', $dosenId);
                    }
                    $query->where('jenis', 'penguji')->where('urut', 1);
                });
            })->where('status', 'sudah_terjadwal')->get(),
            'jadwalPenguji2' => Sidang::whereHas('tugas_akhir', function ($query) use ($jadwalSidang) {
                $query->whereHas('bimbing_uji', function ($query) use ($jadwalSidang) {
                    $dosenId = $jadwalSidang->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', 2)->first();
                    $dosenId = is_null($dosenId) ? null : $dosenId->dosen_id;

                    if(is_null($dosenId)) {
                        $query->whereNull('dosen_id');
                    } else {
                        $query->where('dosen_id', $dosenId);
                    }
                    $query->where('jenis', 'penguji')->where('urut', 2);
                });
            })->where('status', 'sudah_terjadwal')->get(),
            'mahasiswaTerdaftar' => Sidang::where('status', 'sudah_terjadwal')->whereIn('tanggal', $currentWeekDays)->orderBy('tanggal', 'asc')->get(),
        ];

        // dd($data);
        return view('administrator.jadwal-sidang.form', $data);
    }

    public function update(Request $request, Sidang $jadwalSidang) 
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
            if(!is_null($periode) && Carbon::createFromFormat('Y-m-d',$request->tanggal)->greaterThan(Carbon::parse($periode->akhir_sidang))){
                return redirect()->back()->with(['error' => 'Jadwal sidang melebihi batas periode']);
            }
            if(!is_null($periode) && !Carbon::createFromFormat('Y-m-d', $request->tanggal)->greaterThan(Carbon::parse($periode->mulai_sidang))){
                return redirect()->back()->with(['error' => 'Periode sidang belum aktif']);
            }

            $check = Sidang::whereRuanganId($request->ruangan)->whereDate('tanggal', $request->tanggal)->where('jam_mulai', '>=', $request->jam_mulai)->where('jam_selesai', '<=', $request->jam_selesai)->first();

            if(!is_null($check)) {
                return redirect()->back()->with(['error' => 'Jadwal ini sudah ada']);
            }

            $jadwalSidang->update([
                'ruangan_id' => $request->ruangan,
                'tanggal' => $request->tanggal,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'status' => 'sudah_terjadwal'
            ]);
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
        $recapPenguji1 = $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', 1)->first()->penilaian()->where('type', 'Sidang')->sum('nilai');
        $recapPenguji1 = $recapPenguji1 > 0 ? $recapPenguji1 / $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', 1)->first()->penilaian()->where('type', 'Sidang')->count() : 0;
        $recapPenguji2 = $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', 2)->first()->penilaian()->where('type', 'Sidang')->sum('nilai');
        $recapPenguji2 = $recapPenguji2 > 0 ? $recapPenguji2 / $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', 2)->first()->penilaian()->where('type', 'Sidang')->count() : 0;

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
        $recapPemb1 = $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'pembimbing')->where('urut', 1)->first()->penilaian()->where('type', 'Sidang')->sum('nilai');
        $recapPemb1 = $recapPemb1 > 0 ? $recapPemb1 / $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'pembimbing')->where('urut', 1)->first()->penilaian()->where('type', 'Sidang')->count() : 0;
        $recapPemb2 = $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'pembimbing')->where('urut', 2)->first()->penilaian()->where('type', 'Sidang')->sum('nilai');
        $recapPemb2 = $recapPemb2 > 0 ? $recapPemb2 / $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'pembimbing')->where('urut', 2)->first()->penilaian()->where('type', 'Sidang')->count() : 0;
        $recapPenguji1 = $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', 1)->first()->penilaian()->where('type', 'Sidang')->sum('nilai');
        $recapPenguji1 = $recapPenguji1 > 0 ? $recapPenguji1 / $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', 1)->first()->penilaian()->where('type', 'Sidang')->count() : 0;
        $recapPenguji2 = $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', 2)->first()->penilaian()->where('type', 'Sidang')->sum('nilai');
        $recapPenguji2 = $recapPenguji2 > 0 ? $recapPenguji2 / $sidang->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', 2)->first()->penilaian()->where('type', 'Sidang')->count() : 0;
        
        
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
            $periode = PeriodeTa::where('is_active', true)->first();
            if(!is_null($periode) && !Carbon::parse($periode->akhir_sidang)->addDays(1)->isFuture()){
                return redirect()->back()->with('error', 'Pendaftaran sidang melebihi batas periode');
            }
            if(!is_null($periode) && Carbon::parse($periode->mulai_sidang)->addDays(1)->isFuture()){
                return redirect()->back()->with('error', 'Pendaftaran Sidang Akhir belum aktif');
            }
            $documentTypes = JenisDokumen::all();
            $validates = [];
            $messages = [];
            $inserts = [];
            foreach($documentTypes as $item) {
                if($sidang->status == 'belum_terjadwal') {
                    if($item->jenis == 'pra_sidang') {
                        $validates['document_'. $item->id] = $item->tipe_dokumen == 'pdf' ? '|mimes:pdf|max:'. $item->max_ukuran : 'mimes:png,jpg,jpeg,webp|max:'. $item->max_ukuran;
                        $messages['document_'. $item->id .'.mimes'] = 'Dokumen '. strtolower($item->nama) .' harus dalam format '. ($item->tipe_dokumen == 'pdf' ? 'PDF' : 'PNG, JPEG, JPG, WEBP');
                        $messages['document_'. $item->id .'.max'] = 'Dokumen '. strtolower($item->nama) .' tidak boleh lebih dari '. $item->max_ukuran .' KB';
                    }
                } else {
                    if($item->jenis == 'sidang') {
                        $validates['document_'. $item->id] = $item->tipe_dokumen == 'pdf' ? '|mimes:pdf|max:'. $item->max_ukuran : 'mimes:png,jpg,jpeg,webp|max:'. $item->max_ukuran;
                        $messages['document_'. $item->id .'.mimes'] = 'Dokumen '. strtolower($item->nama) .' harus dalam format '. ($item->tipe_dokumen == 'pdf' ? 'PDF' : 'PNG, JPEG, JPG, WEBP');
                        $messages['document_'. $item->id .'.max'] = 'Dokumen '. strtolower($item->nama) .' tidak boleh lebih dari '. $item->max_ukuran .' KB';
                    }
                }
            }
            
            $request->validate($validates, $messages);

            foreach($documentTypes as $item) {
                if($sidang->status == 'belum_daftar') {
                    if($item->jenis == 'pra_sidang' && $request->hasFile('document_'. $item->id)) {
                        $file = $request->file('document_'. $item->id);
                        $filename = 'document_'. rand(0, 999999999) .'_'. rand(0, 999999999) .'.'. $file->getClientOriginalExtension();
                        $file->move(public_path('storage/files/pemberkasan'), $filename);
    
                        $document = $item->pemberkasan()->where('tugas_akhir_id', $sidang->tugas_akhir->id)->first();
                        if($document) {
                            File::delete(public_path('storage/files/pemberkasan/'. $document->filename));
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
                    if($item->jenis == 'sidang' && $request->hasFile('document_'. $item->id)) {
                        $file = $request->file('document_'. $item->id);
                        $filename = 'document_'. rand(0, 999999999) .'_'. rand(0, 999999999) .'.'. $file->getClientOriginalExtension();
                        $file->move(public_path('storage/files/pemberkasan'), $filename);
                        $document = $item->pemberkasan()->where('tugas_akhir_id', $sidang->tugas_akhir->id)->first();
                        if($document) {
                            File::delete(public_path('storage/files/pemberkasan/'. $document->filename));
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
            if(count($inserts) > 0) {
                Pemberkasan::insert($inserts);
            }

            $sidang->update(['status' => 'sudah_daftar']);
            DB::commit();
            return redirect()->back()->with(['success' => 'Dokumen berhasil ditambahkan']);
        } catch(Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function validasiBerkas(Sidang $jadwalSidang)
    {
        try {
            $jadwalSidang->tugas_akhir()->update(['status_pemberkasan' => 'sudah_lengkap']);

            return redirect()->back()->with(['success' => 'Berkas berhasil diperbarui']);
        } catch (Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function berkasLengkap(Sidang $sidang)
    {
        try {
            $sidang->tugas_akhir->update(['status_pemberkasan' => 'sudah_lengkap']);
            return redirect()->back()->with(['success' => 'Berhasil memperbarui data']);
        } catch(Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function nilai(Request $request, Sidang $sidang)
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
                $check = $sidang->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->penilaian()->where('kategori_nilai_id', $category->id)->where('type', 'Sidang')->first();

                if($check) {
                    $check->update([
                        'nilai' => $request->input('nilai_'.$category->id)
                    ]);
                } else {
                    $ratings[] = [
                        'bimbing_uji_id' => $sidang->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->first()->id,
                        'kategori_nilai_id' => $category->id,
                        'nilai' => $request->input('nilai_'.$category->id),
                        'type' => 'Sidang',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            if(count($ratings) > 0) {
                Penilaian::insert($ratings);
            }
            $sidang->update(['status' => 'sudah_sidang']);
            DB::commit();

            return redirect()->back()->with(['success' => 'Nilai berhasil disimpan']);
        } catch(Exception $e) {
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

            if($check->count() > 0) {
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
        } catch(Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function updateStatus(Request $request, Sidang $sidang)
    {
        $request->validate([
            'status' => 'required',
        ]);

        try {
            $sidang->tugas_akhir->update([
                'status_sidang' => $request->status,
            ]);

            return redirect()->back()->with(['success' => 'Berhasil mengubah status']);
        } catch(Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function export(Request $request)
    {
        $status = $request->input('type');
        $title = '';
        $export = null;

        
        switch ($status) {
            case 'sk_sidang':
                $export = new SKSidangAkhirExport();
                $title = 'SK SIDANG';
                break;
    
            case 'belum_daftar':
                $export = new SemproExport($status);
                $title = 'Belum Terjadwal Sempro';
                break;
    
            case 'telah_seminar':
                $export = new SemproExport($status);
                $title = 'Telah Diseminarkan';
                break;
    
            case 'sudah_pemberkasan':
                $export = new SemproExport($status);
                $title = 'Sudah Pemberkasan Seminar';
                break;
    
            default:
                return redirect()->back()->with('error', 'Jenis export tidak valid.');
        }
    
        $sheets = $export->sheets();
        if (empty($sheets) || count($sheets) === 1 && $sheets[0] instanceof DummySheet) {
            return redirect()->back()->with('error', 'Data Tidak Ditemukan.');
        }

        return Export::download($export, "{$title}.xlsx");
    }
}
