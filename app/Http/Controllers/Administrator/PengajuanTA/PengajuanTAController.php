<?php

namespace App\Http\Controllers\Administrator\PengajuanTA;

use App\Models\Mahasiswa;
use App\Models\TugasAkhir;
use Illuminate\Http\Request;
use App\Models\JadwalSeminar;
use App\Http\Controllers\Controller;
use App\Http\Requests\PengajuanTA\PengajuanTARequest;
use App\Models\BimbingUji;
use App\Models\Dosen;
use App\Models\JenisTa;
use App\Models\KuotaDosen;
use App\Models\PeriodeTa;
use App\Models\Topik;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class PengajuanTAController extends Controller
{
    public function index()
    {
        $myId = getInfoLogin()->username;
        $mahasiswa = Mahasiswa::where('nim', $myId)->first();
        $ta = TugasAkhir::with(['jenis_ta', 'topik'])->where('mahasiswa_id', $mahasiswa->id)->first();

        $seminar = null;
        if(isset($ta->id)){

            $seminar = JadwalSeminar::where('tugas_akhir_id', $ta->id)->first();
        }

        if ($seminar) {
            $waktu_sekarang = date('Y-m-d H:i:s');
            $tgl_sekarang = date('Y-m-d');
            $wk = ($seminar->tanggal . ' ' . $seminar->jam_selesai);
            if ($waktu_sekarang > $wk && $tgl_sekarang >= $seminar->tanggal) {
                $waktu = 'selesai';
            } else {
                $waktu = 'tidak selesai';
            }
        } else {
            $waktu = 'seminar tidak ditemukan';
        }

        $data = [
            'title' => 'Pengajuan Tugas Akhir',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Pengajuan Tugas Akhir',
                    'is_active' => true
                ]
            ],
            'dataTA'   => TugasAkhir::with(['jenis_ta', 'topik'])->where('mahasiswa_id', $mahasiswa->id)->get(),
            'timer' => $waktu,
        ];
        
        return view('administrator.pengajuan-ta.index', $data);
    }

    public function create()
    {
        $periode = PeriodeTa::where('is_active', 1)->first();
        $dataDosen = Dosen::all();
        $dosen = [];
        foreach ($dataDosen as $key) {
            # code...
            $kuota = KuotaDosen::where('dosen_id', $key->id)->where('periode_ta_id', $periode->id)->first();
            $bimbingUji = BimbingUji::with(['tugas_akhir', 'dosen'])->where('dosen_id', $key->id)->where('jenis', 'pembimbing')->where('urut', 1)->whereHas('tugas_akhir', function ($q) use($periode){
                $q->where('periode_ta_id', $periode->id);
            })->count();
            // dd($kuota);
            $dosen[] = (object)[
                'id' => $key->id,
                'nidn' => $key->nidn,
                'nama' => $key->name,
                'name' => $key->name,
                'kuota_pembimbing_1' => ($kuota->pembimbing_1 ?? 0),
                'total_pembimbing_1' => $bimbingUji,
            ];
        }

        $data = [
            'title' => 'Pengajuan Tugas Akhir',
            'dataJenis'   => JenisTa::all(),
            'dataTopik'   => Topik::all(),
            'dataDosen'   => $dosen,
            'dosenKuota'   => $dosen,
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Pengajuan Tugas Akhir',
                    'url' => route('apps.pengajuan-ta')
                ],
                [
                    'title' => 'Tambah Pengajuan Tugas Akhir',
                    'is_active' => true
                ]
            ],
        ];

        // dd(JenisTa::all());

        return view('administrator.pengajuan-ta.partials.form', $data);
    }

    public function store(PengajuanTARequest $request)
    {   
        // dd($request->all());
        try {
            $periode = PeriodeTa::where('is_active', 1)->first();
            $myId = Auth::user()->username;
            $mahasiswa = Mahasiswa::where('nim', $myId)->first();
            $fileDocPemb1 = null;
            $fileDocRing = null;

            $kuota = KuotaDosen::where('dosen_id', $request->pembimbing_1)->where('periode_ta_id', $periode->id)->first();
            $bimbingUji = BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'pembimbing')->where('urut', 1)->where('dosen_id', $request->pembimbing_1)->whereHas('tugas_akhir', function ($q) use($periode){
                $q->where('periode_ta_id', $periode->id);
            })->count();
            // dd(!is_null($kuota) ? $kuota->pemb_1 : 0);
            if($bimbingUji >= (!is_null($kuota) ? $kuota->pembimbing_1 : 0)){

                return redirect()->back()->with('error', 'Kuota dosen pembimbing 1 yang di pilih telah mencapai batas');

            }

            if($request->hasFile('dokumen_pembimbing_1')){
                $file = $request->file('dokumen_pembimbing_1');
                $fileDocPemb1 = 'Pembimbing_1_'. rand(0, 999999999) .'_'. rand(0, 999999999) .'.'. $file->getClientOriginalExtension();
                $file->move(public_path('storage/files/tugas-akhir'), $fileDocPemb1);
            } else {
                $fileDocPemb1 = null;
            }
            // dd($fileDocPemb1);
            
            if($request->hasFile('dokumen_ringkasan')){
                $file = $request->file('dokumen_ringkasan');
                $fileDocRing = 'Ringkasan_'. rand(0, 999999999) .'_'. rand(0, 999999999) .'.'. $file->getClientOriginalExtension();
                $file->move(public_path('storage/files/tugas-akhir'), $fileDocRing);
            } else {
                $fileDocRing = null;
            }

            $result = TugasAkhir::create([
                'jenis_ta_id' => $request->jenis_ta_id,
                'topik_id' => $request->topik,
                'mahasiswa_id' =>$mahasiswa->id,
                'periode_ta_id' => $periode->id,
                'judul' => $request->judul,
                'tipe' => $request->tipe,
                'dokumen_pemb_1' => $fileDocPemb1,
                'dokumen_ringkasan' => $fileDocRing,
                'status' => 'draft',
            ]);

            BimbingUji::create(
                [
                    'tugas_akhir_id' => $result->id,
                    'dosen_id' => $request->pembimbing_1,
                    'jenis' => 'pembimbing',
                    'urut' => 1,
                ]
            );

            return redirect()->route('apps.pengajuan-ta')->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {

            // dd($e->getMessage());
            return redirect()->route('apps.pengajuan-ta')->with('error', $e->getMessage())->withInput($request->all());
        }
    }

    public function edit(TugasAkhir $pengajuanTA)
    {
        $periode = PeriodeTa::where('is_active', 1)->first();
        $dataDosen = Dosen::all();
        $dosen = [];
        foreach ($dataDosen as $key) {
            # code...
            $kuota = KuotaDosen::where('dosen_id', $key->id)->where('periode_ta_id', $periode->id)->first();
            $bimbingUji = BimbingUji::with(['tugas_akhir', 'dosen'])->where('dosen_id', $key->id)->where('jenis', 'pembimbing')->where('urut', 1)->whereHas('tugas_akhir', function ($q) use($periode){
                $q->where('periode_ta_id', $periode->id);
            })->count();
            // dd($kuota);
            $dosen[] = (object)[
                'id' => $key->id,
                'nidn' => $key->nidn,
                'nama' => $key->name,
                'name' => $key->name,
                'kuota_pembimbing_1' => ($kuota->pembimbing_1 ?? 0),
                'total_pembimbing_1' => $bimbingUji,
            ];
        }

        $data = [
            'title' => 'Pengajuan Tugas Akhir',
            'dataJenis'   => JenisTa::all(),
            'dataTopik'   => Topik::all(),
            'dataDosen'   => $dosen,
            'dosenKuota'   => $dosen,
            'editedData' => $pengajuanTA,
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Pengajuan Tugas Akhir',
                    'url' => route('apps.pengajuan-ta'),
                ],
                [
                    'title' => 'Edit Pengajuan Tugas Akhir',
                    'is_active' => true
                ]
            ],
        ];

        // dd(JenisTa::all());

        return view('administrator.pengajuan-ta.partials.form', $data);
    }

    public function update(Request $request, TugasAkhir $pengajuanTA)
    {
        try {
            $ta = $pengajuanTA;
            $fileDocPemb1 = $ta->dokumen_pemb_1;
            $fileDocRing = $ta->dokumen_ringkasan;

            $kuota = KuotaDosen::where('dosen_id', $request->pembimbing_1)->where('periode_ta_id', $ta->periode_ta_id)->first();
            $bimbingUji = BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'pembimbing')->where('urut', 1)->where('dosen_id', $request->pembimbing_1)->whereHas('tugas_akhir', function ($q) use($ta){
                $q->where('periode_ta_id', $ta->periode_ta_id);
            })->count();
            $cekPemb1 = BimbingUji::where('tugas_akhir_id', $pengajuanTA->id)->where('jenis', 'pembimbing')->where('urut', 1)->first();

            if($cekPemb1->dosen_id != $request->pembimbing_1){
                if($bimbingUji >= $kuota->pembimbing_1){

                    return redirect()->back()->with('error', 'Kuota dosen pembimbing 1 yang di pilih telah mencapai batas');

                }
            }

            if($ta->status == 'reject'){
                $status = 'draft';
            }else{
                $status = $ta->status;
            }

            if($request->hasFile('dokumen_pembimbing_1')){
                $file = $request->file('dokumen_pembimbing_1');
                $fileDocPemb1 = 'Pembimbing_1_'. rand(0, 999999999) .'_'. rand(0, 999999999) .'.'. $file->getClientOriginalExtension();
                $file->move(public_path('storage/files/tugas-akhir'), $fileDocPemb1);
                if($pengajuanTA->dokumen_pembimbing_1){
                    File::delete(public_path('storage/files/tugas-akhir/'.$pengajuanTA->dokumen_pembimbing_1));
                }
            } else {
                $fileDocPemb1 = $pengajuanTA->dokumen_pemb_1;
            }

            if($request->hasFile('dokumen_ringkasan')){
                $file = $request->file('dokumen_ringkasan');
                $fileDocRing = 'Ringkasan_'. rand(0, 999999999) .'_'. rand(0, 999999999) .'.'. $file->getClientOriginalExtension();
                $file->move(public_path('storage/files/tugas-akhir'), $fileDocRing);
                if($pengajuanTA->dokumen_ringkasan){
                    File::delete(public_path('storage/files/tugas-akhir/'.$pengajuanTA->dokumen_ringkasan));
                }
            } else {
                $fileDocRing = $pengajuanTA->dokumen_ringkasan;
            }

            $pengajuanTA->update([
                'jenis_ta_id' => $request->jenis_ta_id,
                'topik_id' => $request->topik,
                'judul' => $request->judul,
                'tipe' => $request->tipe,
                'dokumen_pemb_1' => $fileDocPemb1,
                'dokumen_ringkasan' => $fileDocRing,    
                'status' => $status,
            ]);

            BimbingUji::where('tugas_akhir_id', $pengajuanTA->id)->where('jenis', 'pembimbing')->where('urut', 1)->update(
                [
                    'dosen_id' => $request->pembimbing_1,
                ]
            );
            return redirect()->route('apps.pengajuan-ta')->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
            // dd($e->getMessage());
            return redirect()->route('apps.pengajuan-ta')->with('error', $e->getMessage())->withInput($request->all());
        }
    }

    public function show(TugasAkhir $pengajuanTA)
    {
        $data = [
            'title' => 'Detail Pengajuan Tugas Akhir',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Pengajuan Tugas Akhir',
                    'url' => route('apps.pengajuan-ta')
                ],
                [
                    'title' => 'Detail Pengajuan Tugas Akhir',
                    'is_active' => true
                ]
            ]
        ];

        return view('administrator.pengajuan-ta.partials.detail', $data);
    }
}
