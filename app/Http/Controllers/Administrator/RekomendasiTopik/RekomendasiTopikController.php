<?php

namespace App\Http\Controllers\Administrator\RekomendasiTopik;

use Carbon\Carbon;
use App\Models\Dosen;
use App\Models\JenisTa;
use App\Models\Mahasiswa;
use App\Models\AmbilTawaran;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Models\RekomendasiTopik;
use App\Mail\RekomendasiTopikMail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\RekomendasiTopik\RekomendasiTopikRequest;

class RekomendasiTopikController extends Controller
{
    public function index()
    {
        $user = getInfoLogin()->userable;
        $query = RekomendasiTopik::with(['dosen', 'jenisTa', 'ambilTawaran']);
        if (session('switchRoles') == 'Dosen') {
            $dosen = Dosen::where('id', $user->id)->first();
            $query->where('dosen_id', $dosen->id);
        }
        if (session('switchRoles') == 'Mahasiswa') {
            $prodi = $user->programStudi;
            $query->where('program_studi_id', $prodi->id)->where('status', 'Disetujui')
                ->whereDoesntHave('ambilTawaran', function ($q) use ($user) {
                    $q->where('mahasiswa_id', $user->id)
                        ->where('status', 'Disetujui');
                })
                ->where(function ($query) {
                    $query->whereHas('ambilTawaran', function ($q) {
                        $q->where('status', 'Disetujui');
                    }, '<', DB::raw('kuota'));
                });
        }
        if (session('switchRoles') == 'Kaprodi') {
            $prodi = $user->programStudi;
            $query->where('program_studi_id', $prodi->id);
        }
        $q = $query->get();

        $data = [
            'title' => 'Tawaran Tugas Akhir',
            'mods' => 'rekomendasi_topik',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Tawaran Tugas Akhir',
                    'is_active' => true
                ]
            ],
            'data' => $q,
            'prodi' => ProgramStudi::all(),
            'jenisTa' => JenisTa::all(),
        ];
        return view('administrator.rekomendasi-topik.index', $data);
    }

    public function store(RekomendasiTopikRequest $request)
    {
        try {
            $user = Auth::user();
            $dosen = Dosen::where('id', $user->userable_id)->first();
            if(!$dosen) {
                return redirect()->route('apps.rekomendasi-topik')->with('error', 'Anda tidak terdaftar sebagai dosen');
            }
            if($request->jenis_ta_new !== null) {
                $newJenis =JenisTa::create(['nama_jenis' => $request->jenis_ta_new]);
                $jenis = $newJenis->id;
            } else {
                $jenis = $request->jenis_ta_id;
            }
            $kuota = (int) $request->kuota;
            $request->merge(['dosen_id' => $dosen->id, 'kuota' => $kuota, 'jenis_ta_id' => $jenis,  'status' => 'Menunggu']);                   
            RekomendasiTopik::create($request->only(['dosen_id','jenis_ta_id', 'judul', 'tipe', 'kuota', 'deskripsi', 'status', 'program_studi_id']));
            return redirect()->route('apps.rekomendasi-topik')->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->route('apps.rekomendasi-topik')->with('error', $e->getMessage());
        }
    }

    public function show(RekomendasiTopik $rekomendasiTopik)
    {
        return response()->json($rekomendasiTopik);
    }

    public function update(RekomendasiTopikRequest $request, RekomendasiTopik $rekomendasiTopik)
    {
        try {
            if($request->jenis_ta_new !== null) {
                $newJenis =JenisTa::create(['nama_jenis' => $request->jenis_ta_new]);
                $jenis = $newJenis->id;

            } else {
                $jenis = $request->jenis_ta_id;
            }
            $kuota = (int) $request->kuota;
            $request->merge(['kuota' => $kuota, 'jenis_ta_id' => $jenis, 'status' => $rekomendasiTopik->status == 'Disetujui' ? 'Disetujui' : 'Menunggu', 'catatan' => null]);
            $rekomendasiTopik->update($request->only(['jenis_ta_id', 'judul', 'tipe', 'kuota', 'deskripsi', 'status', 'catatan','program_studi_id']));
            return redirect()->route('apps.rekomendasi-topik')->with('success', 'Data berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->route('apps.rekomendasi-topik')->with('error', $e->getMessage());
        }
    }

    public function destroy(RekomendasiTopik $rekomendasiTopik)
    {
        try {
            $rekomendasiTopik->delete();
            return $this->successResponse('Data berhasil di hapus');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function detail(RekomendasiTopik $rekomendasiTopik) 
    {
        $rekomendasiTopik->load(['ambilTawaran' => function($query) {
            $query->where('status', '!=', 'Ditolak');
        }]);
    
        $data = [
            'title' => 'Detail Tawaran Tugas Akhir',
            'mods' => 'rekomendasi_topik',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Tawaran Tugas Akhir',
                    'url' => route('apps.rekomendasi-topik')
                ],
                [
                    'title' => 'Detail Tawaran Topik',
                    'is_active' => true
                ]
            ],
            'data' => $rekomendasiTopik
        ];

        return view('administrator.rekomendasi-topik.detail', $data);
    }
    
    public function apply()
    {
        $user = Auth::user();
        $mhs = Mahasiswa::where('id', $user->userable_id)->first();
        if (!$mhs) {
            $query = collect([]);
            $message = 'Anda belum terdaftar sebagai mahasiswa';
        } else {
            $query = AmbilTawaran::where('mahasiswa_id', $mhs->id)->with(['mahasiswa', 'rekomendasiTopik'])->get();
            $message = '';
        }
        $data = [
            'title' => 'Topik Yang Diambil',
            'mods' => 'rekomendasi_topik',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Topik Yang Diambil',
                    'is_active' => true
                ]
            ],
            'data' => $query,
            'message' => $message
        ];

        return view('administrator.rekomendasi-topik.apply', $data);
    }

    public function ambilTopik(RekomendasiTopik $rekomendasiTopik, Request $request)
    {
        $request->validate([
            'description' => 'required',
            'document' => 'required|max:2048|mimes:pdf',
        ],[
            'description.required' => 'Deskripsi harus diisi',
            'document.required' => 'Dokumen harus diisi',
            'document.max' => 'Dokumen maksimal 2 MB',
            'document.mimes' => 'Dokumen harus berformat PDF',
        ]);

        try {
            $mhs = Mahasiswa::where('id', getInfoLogin()->userable_id)->first();
            if (!$mhs) {
                return redirect()->route('apps.rekomendasi-topik')->with('error','Anda belum terdaftar sebagai mahasiswa');
            }

            $existingTawaran = AmbilTawaran::where('mahasiswa_id', $mhs->id)->where('status', '!=', 'Ditolak')->first();
            if ($existingTawaran) {
                return redirect()->route('apps.rekomendasi-topik')->with('error', 'Anda sudah mengambil topik, silahkan menunggu konfirmasi');
            }
            
            $exists = AmbilTawaran::where('mahasiswa_id', $mhs->id)->where('rekomendasi_topik_id', $rekomendasiTopik->id)->first();
            if ($exists) {
                return redirect()->route('apps.rekomendasi-topik')->with('error','Anda sudah mengambil topik ini');
            }

            if($request->hasFile('document')) {
                $file = $request->file('document');
                $filename = 'Lampiran_'. rand(0, 999999999) .'_'. rand(0, 999999999) .'.'. $file->getClientOriginalExtension();
                $file->move(public_path('storage/files/apply-topik'), $filename);
            } else {
                $filename = null;
            }

            AmbilTawaran::create([
                'mahasiswa_id' => $mhs->id,
                'rekomendasi_topik_id' => $rekomendasiTopik->id,
                'description' => $request->description,
                'file' => $filename,
                'date' => Carbon::now(),
                'status' => 'Menunggu',
            ]);

            return redirect()->route('apps.rekomendasi-topik')->with('success', 'Berhasil mengirim data');
        } catch (\Exception $e) {
            return redirect()->route('apps.rekomendasi-topik')->with($e->getMessage());
        }
    }
    

    public function deleteTopik(AmbilTawaran $ambilTawaran)
    {
        try {
            $ambilTawaran->delete();
            return $this->successResponse('Berhasil menghapus topik yang diambil');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function accept(AmbilTawaran $ambilTawaran)
    {
        try {
            DB::beginTransaction();
            $kuota = $ambilTawaran->rekomendasiTopik->kuota;
            $rekomendasiTopik = $ambilTawaran->rekomendasiTopik;
            if ($rekomendasiTopik->ambilTawaran()->where('status', 'Disetujui')->count() >= $kuota) {
                return redirect()->route('apps.rekomendasi-topik.detail', $rekomendasiTopik->id)->with('error', 'Kuota sudah habis');
            }
            $ambilTawaran->update(['status' => 'Disetujui']);
            $mahasiswa = $ambilTawaran->mahasiswa;
            if ($mahasiswa) {
                // Mail::to($mahasiswa->email)->send(new RekomendasiTopikMail($rekomendasiTopik, $mahasiswa));
            }
            if ($rekomendasiTopik->ambilTawaran()->where('status', 'Disetujui')->count() >= $kuota) {
                AmbilTawaran::where('rekomendasi_topik_id', $rekomendasiTopik->id)->where('status', 'Menunggu')->update(['status' => 'Ditolak']);
            }
            DB::commit();
            return redirect()->route('apps.rekomendasi-topik.detail', $rekomendasiTopik->id)->with('success', 'Berhasil menyetujui data.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function reject(AmbilTawaran $ambilTawaran)
    {
        try {
            DB::beginTransaction();
            $rekomendasiTopik = $ambilTawaran->rekomendasiTopik;
            $ambilTawaran->update(['status' => 'Ditolak']);
            DB::commit();
            return redirect()->route('apps.rekomendasi-topik.detail', $rekomendasiTopik->id)->with('success', 'Berhasil menolak data.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function deleteMhs(AmbilTawaran $ambilTawaran)
    {  
        try {
            $topik = $ambilTawaran->rekomendasi_topik_id;
            if($ambilTawaran->file) {
                File::delete(public_path('storage/files/apply-topik/'. $ambilTawaran->file));
            }
            $ambilTawaran->delete();
            return $this->successResponse('Berhasil menghapus data');
        } catch(\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function acc(RekomendasiTopik $rekomendasiTopik)
    {
        try {
            $rekomendasiTopik->update(['status' => 'Disetujui', 'catatan' => null]);
            return redirect()->route('apps.rekomendasi-topik')->with('success', 'Berhasil menyetujui data');
        } catch (\Exception $e) {
            return redirect()->route('apps.rekomendasi-topik')->with($e->getMessage());
        }
    }

    public function rejectTopik(Request $request, RekomendasiTopik $rekomendasiTopik)
    {  
        $request->validate([
            'catatan' => 'nullable',
        ]);

        try {
            $rekomendasiTopik->update(['status' => 'Ditolak', 'catatan' => $request->catatan]);
            return redirect()->route('apps.rekomendasi-topik')->with('success', 'Berhasil menolak data');
        } catch (\Exception $e) {
            return redirect()->route('apps.rekomendasi-topik')->with($e->getMessage());
        }
    }

    public function editTopik(AmbilTawaran $ambilTawaran) 
    {
        return response()->json($ambilTawaran);
    }  

    public function updateTopik(AmbilTawaran $ambilTawaran, Request $request)
    {
        $request->validate([
            'description' => 'required',
            'document' => 'nullable|max:2048|mimes:pdf',
        ],[
            'description.required' => 'Deskripsi harus diisi',
            'document.max' => 'Dokumen maksimal 2 MB',
            'document.mimes' => 'Dokumen harus berformat PDF',
        ]);

        try {
            if($request->hasFile('document')) {
                $file = $request->file('document');
                $filename = 'Lampiran_'. rand(0, 999999999) .'_'. rand(0, 999999999) .'.'. $file->getClientOriginalExtension();
                $file->move(public_path('storage/files/apply-topik'), $filename);
            } else {
                $filename = $ambilTawaran->file;
            }

            $ambilTawaran->update([
                'description' => $request->description,
                'file' => $filename,
            ]);

            return redirect()->route('apps.topik-yang-diambil')->with('success', 'Berhasil memperbarui data');
        } catch (\Exception $e) {
            return redirect()->route('apps.topik-yang-diambil')->with($e->getMessage());
        }
    }

}
