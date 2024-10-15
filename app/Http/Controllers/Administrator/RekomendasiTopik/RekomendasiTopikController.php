<?php

namespace App\Http\Controllers\Administrator\RekomendasiTopik;

use Carbon\Carbon;
use App\Models\Dosen;
use App\Models\JenisTa;
use App\Models\Mahasiswa;
use App\Models\AmbilTawaran;
use Illuminate\Http\Request;
use App\Models\RekomendasiTopik;
use App\Mail\RekomendasiTopikMail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\RekomendasiTopik\RekomendasiTopikRequest;

class RekomendasiTopikController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $dosen = Dosen::where('id', $user->userable_id)->first();
        if($user->hasRole('Dosen')) {
            $query = RekomendasiTopik::with(['dosen', 'jenisTa', 'ambilTawaran'])->where('dosen_id', $dosen->id)->get();
        } else {
            $query = RekomendasiTopik::with(['dosen', 'jenisTa', 'ambilTawaran.mahasiswa'])->where('kuota', '!=', '0')->get();
        }

        $data = [
            'title' => 'Rekomendasi Topik TA',
            'mods' => 'rekomendasi_topik',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Rekomendasi Topik',
                    'is_active' => true
                ]
            ],
            'data' => $query,
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
            $request->merge(['dosen_id' => $dosen->id]);                   
            RekomendasiTopik::create($request->only(['dosen_id','jenis_ta_id', 'judul', 'tipe', 'kuota']));
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
            $rekomendasiTopik->update($request->only(['jenis_ta_id', 'judul', 'tipe', 'kuota']));
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
        $rekomendasiTopik->ambilTawaran;

        $data = [
            'title' => 'Detail Rekomendasi Topik',
            'mods' => 'rekomendasi_topik',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Rekomendasi Topik',
                    'url' => route('apps.rekomendasi-topik')
                ],
                [
                    'title' => 'Detail Rekomendasi Topik',
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
            'document' => 'required|max:2048',
        ],[
            'description.required' => 'Deskripsi harus diisi',
            'document.required' => 'Dokumen harus diisi',
            'document.max' => 'Dokumen maksimal 2 MB',
        ]);

        try {
            $mhs = Mahasiswa::where('id', getInfoLogin()->userable_id)->first();
            if (!$mhs) {
                return redirect()->route('apps.rekomendasi-topik')->with('error','Anda belum terdaftar sebagai mahasiswa');
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

    public function accept(RekomendasiTopik $rekomendasiTopik, Request $request)
    { 
        try {
            DB::beginTransaction();
            $selected = $request->input('selected_items');
            if(!$selected) {
                return redirect()->back()->with('error', 'Pilih setidaknya 1 untuk disetujui.');
            }
            foreach ($selected as $id) {
                $item = AmbilTawaran::find($id);
                if($item) {
                    $item->update(['status' => 'Disetujui']);
                }
                $mahasiswa = $item->mahasiswa;
                if ($mahasiswa) {
                   Mail::to($mahasiswa->email)->send(new RekomendasiTopikMail($rekomendasiTopik, $mahasiswa));
                }
            }
            $rekomendasiTopik->update(['kuota' => $rekomendasiTopik->kuota - count($selected),]);

            DB::commit();
            return redirect()->route('apps.rekomendasi-topik.detail', $rekomendasiTopik->id)->with('success', 'Berhasil menyetujui data');
        } catch (\Exception $e) {
            return redirect()->back()->with($e->getMessage());
        }
    }

    public function deleteMhs(RekomendasiTopik $rekomendasiTopik)
    {
        try {
            $ambilTawaran = AmbilTawaran::where('rekomendasi_topik_id', $rekomendasiTopik->id)->first();
            $ambilTawaran->delete();
            $rekomendasiTopik->increment('kuota');

            return $this->successResponse('Berhasil menghapus data');
        } catch(\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function reject(RekomendasiTopik $rekomendasiTopik, Request $request)
    {
        try {
            DB::beginTransaction();
            $selected = $request->input('selected_items');
            if (!$selected) {
                return redirect()->back()->with('error', 'Pilih setidaknya 1 untuk ditolak.');
            }
            foreach ($selected as $id) {
                $item = AmbilTawaran::find($id);
                if ($item) {
                    $item->update(['status' => 'Ditolak']);
                }
            }
            DB::commit();
            return redirect()->route('apps.rekomendasi-topik.detail', $rekomendasiTopik)->with('success', 'Berhasil menolak data');
        } catch(\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

}
