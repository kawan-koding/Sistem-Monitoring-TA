<?php

namespace App\Http\Controllers\Administrator\JadwalSidang;

use Carbon\Carbon;
use App\Models\Sidang;
use App\Models\Mahasiswa;
use App\Models\PeriodeTa;
use App\Models\Pemberkasan;
use App\Models\JenisDokumen;
use Illuminate\Http\Request;
use App\Models\KategoriNilai;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

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
            if(!is_null($periode) && !Carbon::parse($periode->mulai_sidang)->addDays(1)->isFuture()){
                return redirect()->back()->with('error', 'Pendaftaran sidang melebihi batas periode');
            }
            if(!is_null($periode) && Carbon::parse($periode->akhir_sidang)->addDays(1)->isFuture()){
                return redirect()->back()->with('error', 'Pendaftaran Sidang Akhir belum aktif');
            }
            $documentTypes = JenisDokumen::all();
            $validates = [];
            $messages = [];
            $inserts = [];
            foreach($documentTypes as $item) {
                if($jadwalSeminar->status == 'belum_terjadwal') {
                    if($item->jenis == 'pra_sidang') {
                        $validates['document_'. $item->id] = '|mimes:pdf,png,jpeg,jpg|max:2048';
                        $messages['document_'. $item->id .'.mimes'] = 'Dokumen '. strtolower($item->nama) .' harus dalam format PDF, PNG, JPEG dan JPG';
                        $messages['document_'. $item->id .'.max'] = 'Dokumen '. strtolower($item->nama) .' tidak boleh lebih dari 2 MB';
                    }
                } else {
                    if($item->jenis == 'sidang') {
                        $validates['document_'. $item->id] = '|mimes:pdf,png,jpeg,jpg|max:2048';
                        $messages['document_'. $item->id .'.mimes'] = 'Dokumen '. strtolower($item->nama) .' harus dalam format PDF, PNG, JPEG dan JPG';
                        $messages['document_'. $item->id .'.max'] = 'Dokumen '. strtolower($item->nama) .' tidak boleh lebih dari 2 MB';
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
}
