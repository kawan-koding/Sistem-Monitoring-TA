<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use App\Models\JenisTa;
use App\Models\Topik;
use App\Models\TugasAkhir;
use App\Models\PeriodeTa;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\User;
use App\Models\BimbingUji;
use App\Models\KuotaDosen;
use App\Models\JadwalSeminar;
use App\Models\Nilai;
use App\Models\DetailNilai;
use App\Models\Revisi;
use App\Models\Setting;
use App\Models\UraianRevisi;
use PDF;

class PengajuanTaMahasiswaController extends Controller
{
    public function index()
    {
        $myId = Auth::guard('web')->user()->username;
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
        // dd($waktu);
        return view('mahasiswa-menu.pengajuan.index', [
            "title" => "Pengajuan TA",
            "breadcrumb1" => "Pengajuan TA",
            "breadcrumb2" => "Index",
            'dataTA'   => TugasAkhir::with(['jenis_ta', 'topik'])->where('mahasiswa_id', $mahasiswa->id)->get(),
            'timer' => $waktu,
            'jsInit'      => 'js_jadwal_bimbingan_mahasiswa.js',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $periode = PeriodeTa::where('is_active', 1)->first();
        $dataDosen = Dosen::all();
        $dosen = [];
        foreach ($dataDosen as $key) {
            # code...
            $kuota = KuotaDosen::where('dosen_id', $key->id)->where('periode_ta_id', $periode->id)->first();
            $bimbingUji = BimbingUji::with(['tugas_akhir', 'dosen'])->where('dosen_id', $key->id)->where('jenis', 'pembimbing')->where('urut', 1)->whereHas('tugas_akhir', function ($q) use($periode){
                $q->where('periode_ta_id', $periode->id);
            })->count();
            // dd(10);
            $dosen[] = (object)[
                'id' => $key->id,
                'nidn' => $key->nidn,
                'nama' => $key->name,
                'name' => $key->name,
                'kuota_pemb_1' => ($kuota->pemb_1 ?? 0),
                'total_pemb_1' => $bimbingUji,
            ];
        }

        // dd($dosen);
        return view('mahasiswa-menu.pengajuan.form', [
            "title" => "Pengajuan TA",
            "breadcrumb1" => "Pengajuan TA",
            "breadcrumb2" => "Tambah",
            'dataJenis'   => JenisTa::all(),
            'dataTopik'   => Topik::all(),
            'dataDosen'   => $dosen,
            'dosenKuota'   => $dosen,
            'jsInit'      => 'js_jadwal_bimbingan_mahasiswa.js',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // dd(Auth::guard('web')->user()->id);
        try {

            $rules = [
                // 'dokumen_pembimbing_1' => 'required|mimes:pdf,docx',
                'dokumen_ringkasan' => 'required|mimes:docx,pdf',
            ];

            $messages = [
                // 'dokumen_pembimbing_1.required' => 'Dokumen pembimbing 1 tidak boleh kosong!',
                'dokumen_ringkasan.required' => 'Dokumen ringkasan tidak boleh kosong!',
                'dokumen_ringkasan.mimes' => 'Dokumen ringkasan harus dalam format PDF atau DOCX.',
                'dokumen_pembimbing_1.mimes' => 'Dokumen pembimbing 1 harus dalam format PDF atau DOCX.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all())->with('gagal', 'Anda gagal menambahkan data!!');
            }

            $periode = PeriodeTa::where('is_active', 1)->first();
            $myId = Auth::guard('web')->user()->username;
            $mahasiswa = Mahasiswa::where('nim', $myId)->first();
            $docPemb1 = null;
            $docRing = null;

            $kuota = KuotaDosen::where('dosen_id', $request->pemb_1)->where('periode_ta_id', $periode->id)->first();
            $bimbingUji = BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'pembimbing')->where('urut', 1)->where('dosen_id', $request->pemb_1)->whereHas('tugas_akhir', function ($q) use($periode){
                $q->where('periode_ta_id', $periode->id);
            })->count();

            if($bimbingUji >= $kuota->pemb_1){

                return redirect()->back()->with('error', 'Kuota dosen pembimbing 1 yang di pilih telah mencapai batas');

            }

            if(isset($request->dokumen_pembimbing_1)){
                $docPemb1 = $request->dokumen_pembimbing_1->getClientOriginalName() . '-' . time() . '.' . $request->dokumen_pembimbing_1->extension();
                $request->dokumen_pembimbing_1->move(public_path('dokumen'), $docPemb1);
                // dd(1);
            }

            if(isset($request->dokumen_ringkasan)){
                $docRing = $request->dokumen_ringkasan->getClientOriginalName() . '-' . time() . '.' . $request->dokumen_ringkasan->extension();
                $request->dokumen_ringkasan->move(public_path('dokumen'), $docRing);
                // dd(1);
            }

            $result = TugasAkhir::create([
                'jenis_ta_id' => $request->jenis,
                'topik_id' => $request->topik,
                'mahasiswa_id' =>$mahasiswa->id,
                'periode_ta_id' => $periode->id,
                'judul' => $request->judul,
                'tipe' => $request->tipe,
                'dokumen_pemb_1' => $docPemb1,
                'dokumen_ringkasan' => $docRing,
                'status' => 'draft',
                'periode_mulai' => $request->periode_mulai,
                'periode_akhir' => $request->periode_akhir,
            ]);

            BimbingUji::create(
                [
                    'tugas_akhir_id' => $result->id,
                    'dosen_id' => $request->pemb_1,
                    'jenis' => 'pembimbing',
                    'urut' => 1,
                ]
            );

            return redirect()->route('mahasiswa.pengajuan-ta')->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {

            // dd($e->getMessage());
            return redirect()->route('mahasiswa.pengajuan-ta')->with('error', $e->getMessage())->withInput($request->all());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //

        return view('mahasiswa-menu.pengajuan.detail', [
            "title" => "Pengajuan TA",
            "breadcrumb1" => "Pengajuan TA",
            "breadcrumb2" => "Detail",
            'data'        => TugasAkhir::find($id),
            'pembimbing1'  => BimbingUji::with(['dosen'])->where('jenis', 'pembimbing')->where('urut', 1)->where('tugas_akhir_id', $id)->first(),
            'pembimbing2'  => BimbingUji::with(['dosen'])->where('jenis', 'pembimbing')->where('urut', 2)->where('tugas_akhir_id', $id)->first(),
            'penguji1'  => BimbingUji::with(['dosen'])->where('jenis', 'penguji')->where('urut', 1)->where('tugas_akhir_id', $id)->first(),
            'penguji2'  => BimbingUji::with(['dosen'])->where('jenis', 'penguji')->where('urut', 2)->where('tugas_akhir_id', $id)->first(),
            'jsInit'      => 'js_jadwal_bimbingan_mahasiswa.js',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $periode = PeriodeTa::where('is_active', 1)->first();
        $dataDosen = Dosen::all();
        $dosen = [];
        foreach ($dataDosen as $key) {
            # code...
            $kuota = KuotaDosen::where('dosen_id', $key->id)->where('periode_ta_id', $periode->id)->first();
            $bimbingUji = BimbingUji::with(['tugas_akhir', 'dosen'])->where('dosen_id', $key->id)->where('jenis', 'pembimbing')->where('urut', 1)->whereHas('tugas_akhir', function ($q) use($periode){
                $q->where('periode_ta_id', $periode->id);
            })->count();
            // dd(10);
            $dosen[] = (object)[
                'id' => $key->id,
                'nidn' => $key->nidn,
                'nama' => $key->name,
                'name' => $key->name,
                'kuota_pemb_1' => ($kuota->pemb_1 ?? 0),
                'total_pemb_1' => $bimbingUji,
            ];
        }
        return view('mahasiswa-menu.pengajuan.form-edit', [
            "title" => "Pengajuan TA",
            "breadcrumb1" => "Pengajuan TA",
            "breadcrumb2" => "Edit",
            'dataJenis'   => JenisTa::all(),
            'dataTopik'   => Topik::all(),
            'data'        => TugasAkhir::find($id),
            'dataDosen'   => $dosen,
            'dosenKuota'   => $dosen,
            'bimbingUji'   => BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'pembimbing')->where('urut', 1)->where('tugas_akhir_id', $id)->first(),
            'jsInit'      => 'js_jadwal_bimbingan_mahasiswa.js',
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        // dd(Auth::guard('web')->user()->id);
        try {

            $rules = [
                'dokumen_pembimbing_1' => 'mimes:pdf,docx',
                'dokumen_ringkasan' => 'mimes:docx,pdf',
            ];

            $messages = [
                'dokumen_ringkasan.mimes' => 'Dokumen ringkasan harus dalam format PDF atau DOCX.',
                'dokumen_pembimbing_1.mimes' => 'Dokumen pembimbing 1 harus dalam format PDF atau DOCX.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all())->with('gagal', 'Anda gagal menambahkan data!!');
            }

            $ta = TugasAkhir::where('id', $id)->first();
            $docPemb1 = $ta->dokumen_pemb_1;
            $docRing = $ta->dokumen_ringkasan;

            $kuota = KuotaDosen::where('dosen_id', $request->pemb_1)->where('periode_ta_id', $ta->periode_ta_id)->first();
            $bimbingUji = BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'pembimbing')->where('urut', 1)->where('dosen_id', $request->pemb_1)->whereHas('tugas_akhir', function ($q) use($ta){
                $q->where('periode_ta_id', $ta->periode_ta_id);
            })->count();
            $cekPemb1 = BimbingUji::where('tugas_akhir_id', $id)->where('jenis', 'pembimbing')->where('urut', 1)->first();

            if($cekPemb1->dosen_id != $request->pemb_1){
                if($bimbingUji >= $kuota->pemb_1){

                    return redirect()->back()->with('error', 'Kuota dosen pembimbing 1 yang di pilih telah mencapai batas');

                }
            }


            if($ta->status == 'reject'){
                $status = 'draft';
            }else{
                $status = $ta->status;
            }

            if(isset($request->dokumen_pembimbing_1)){
                $docPemb1 = $request->dokumen_pembimbing_1->getClientOriginalName() . '-' . time() . '.' . $request->dokumen_pembimbing_1->extension();
                $request->dokumen_pembimbing_1->move(public_path('dokumen'), $docPemb1);
                // dd(1);
            }

            if(isset($request->dokumen_ringkasan)){
                $docRing = $request->dokumen_ringkasan->getClientOriginalName() . '-' . time() . '.' . $request->dokumen_ringkasan->extension();
                $request->dokumen_ringkasan->move(public_path('dokumen'), $docRing);
                // dd(1);
            }

            $result = TugasAkhir::where('id', $id)->update([
                'jenis_ta_id' => $request->jenis,
                'topik_id' => $request->topik,
                'judul' => $request->judul,
                'tipe' => $request->tipe,
                'dokumen_pemb_1' => $docPemb1,
                'dokumen_ringkasan' => $docRing,
                'status' => $status,
                'periode_mulai' => $request->periode_mulai,
                'periode_akhir' => $request->periode_akhir,
            ]);

            BimbingUji::where('tugas_akhir_id', $id)->where('jenis', 'pembimbing')->where('urut', 1)->update(
                [
                    'dosen_id' => $request->pemb_1,
                ]
            );
            return redirect()->route('mahasiswa.pengajuan-ta')->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {

            // dd($e->getMessage());
            return redirect()->route('mahasiswa.pengajuan-ta')->with('error', $e->getMessage())->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function unggah_berkas(string $id, Request $request)
    {
        // dd($request->all());
        try{
            $rules = [
                'pengesahan' => 'nullable|mimes:pdf,docx',
                'proposal' => 'nullable|mimes:docx,pdf',
                'file_persetujuan_pemb_2' => 'nullable|mimes:docx,pdf',
            ];

            $messages = [
                // 'pengesahan.required' => 'Dokumen pembimbing 1 tidak boleh kosong!',
                // 'proposal.required' => 'Dokumen ringkasan tidak boleh kosong!',
                'proposal.mimes' => 'Dokumen ringkasan harus dalam format PDF atau DOCX.',
                'pengesahan.mimes' => 'Dokumen pembimbing 1 harus dalam format PDF atau DOCX.',
                'file_persetujuan_pemb_2.mimes' => 'File persetujuan pembimbing 2 harus dalam format PDF atau DOCX.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all())->with('gagal', 'Anda gagal menambahkan data!!');
            }

            $data = TugasAkhir::where('id', $id)->first();

            $docPeng = $data->file_pengesahan ?? null;
            $docPro = $data->file_proposal ?? null;
            $file_persetujuan_pemb_2 = $data->file_persetujuan_pemb_2 ?? null;

            if(isset($request->pengesahan)){
                $docPeng = $request->pengesahan->getClientOriginalName() . '-' . time() . '.' . $request->pengesahan->extension();
                $request->pengesahan->move(public_path('dokumen'), $docPeng);
                // dd(1);
            }

            if(isset($request->proposal)){
                $docPro = $request->proposal->getClientOriginalName() . '-' . time() . '.' . $request->proposal->extension();
                $request->proposal->move(public_path('dokumen'), $docPro);
                // dd(1);
            }
            if(isset($request->file_persetujuan_pemb_2)){
                $file_persetujuan_pemb_2 = $request->file_persetujuan_pemb_2->getClientOriginalName() . '-' . time() . '.' . $request->file_persetujuan_pemb_2->extension();
                $request->file_persetujuan_pemb_2->move(public_path('dokumen'), $file_persetujuan_pemb_2);
                // dd(1);
            }

            TugasAkhir::where('id', $id)->update([
                'file_pengesahan' => $docPeng,
                'file_proposal' => $docPro,
                'file_persetujuan_pemb_2' => $file_persetujuan_pemb_2,
            ]);

            return redirect()->back()->with('success','Berhasil unggah berkas');

        }catch(\Exception $e){
            return redirect()->route('mahasiswa.pengajuan-ta')->with('error', $e->getMessage())->withInput($request->all());
        }
    }

    public function print_nilai($id)
    {
        set_time_limit(0);
        $ta = TugasAkhir::find($id);
        $nilai = Nilai::where('tugas_akhir_id', $id)->get();
        // return view('mahasiswa-menu.pengajuan.print-nilai');
        $pdf = PDF::loadview('mahasiswa-menu.pengajuan.print-nilai',[
            'ta' => $ta,
            'nilai' => $nilai,
        ]);
    	return $pdf->stream('laporan-nilai.pdf');
    }

    public function print_rekap($id)
    {
        App::setLocale('id');
        set_time_limit(0);
        $ta = TugasAkhir::find($id);
        $nilai = Nilai::where('tugas_akhir_id', $id)->get();
        $nilai_pemb_1 = DetailNilai::with(['nilai'])->whereHas('nilai', function($q)use($ta){
            $q->where('tugas_akhir_id', $ta->id)->where('jenis', 'pembimbing')->where('urut', 1);
        })->sum('angka');
        $nilai_pemb_2 = DetailNilai::with(['nilai'])->whereHas('nilai', function($q)use($ta){
            $q->where('tugas_akhir_id', $ta->id)->where('jenis', 'pembimbing')->where('urut', 2);
        })->sum('angka');
        $nilai_peng_1 = DetailNilai::with(['nilai'])->whereHas('nilai', function($q)use($ta){
            $q->where('tugas_akhir_id', $ta->id)->where('jenis', 'penguji')->where('urut', 1);
        })->sum('angka');
        $nilai_peng_2 = DetailNilai::with(['nilai'])->whereHas('nilai', function($q)use($ta){
            $q->where('tugas_akhir_id', $ta->id)->where('jenis', 'penguji')->where('urut', 2);
        })->sum('angka');

        $total_pemb_1 = DetailNilai::with(['nilai'])->whereHas('nilai', function($q)use($ta){
            $q->where('tugas_akhir_id', $ta->id)->where('jenis', 'pembimbing')->where('urut', 1);
        })->count();
        $total_pemb_2 = DetailNilai::with(['nilai'])->whereHas('nilai', function($q)use($ta){
            $q->where('tugas_akhir_id', $ta->id)->where('jenis', 'pembimbing')->where('urut', 2);
        })->count();
        $total_peng_1 = DetailNilai::with(['nilai'])->whereHas('nilai', function($q)use($ta){
            $q->where('tugas_akhir_id', $ta->id)->where('jenis', 'penguji')->where('urut', 1);
        })->count();
        $total_peng_2 = DetailNilai::with(['nilai'])->whereHas('nilai', function($q)use($ta){
            $q->where('tugas_akhir_id', $ta->id)->where('jenis', 'penguji')->where('urut', 2);
        })->count();

        $tanggal_indonesia = Carbon::now()->isoFormat('D MMMM YYYY');

        $data = (object)[
            'nilai_pemb_1' => $nilai_pemb_1,
            'nilai_pemb_2' => $nilai_pemb_2,
            'nilai_peng_1' => $nilai_peng_1,
            'nilai_peng_2' => $nilai_peng_2,
            'total_pemb_1' => $total_pemb_1,
            'total_pemb_2' => $total_pemb_2,
            'total_peng_1' => $total_peng_1,
            'total_peng_2' => $total_peng_2,
        ];

        $user_kaprodi = User::role('kaprodi')->first();
        $dos = Dosen::where('user_id', $user_kaprodi)->first();
        $kaprodi = (object)[
            'name' => $user_kaprodi->name,
            'username' => $user_kaprodi->username,
            'nip' => $dos->nip ?? null,
        ];

        $pdf = PDF::loadview('mahasiswa-menu.pengajuan.print-rekap',[
            'ta' => $ta,
            'nilai' => $nilai,
            'data' => $data,
            'tanggal' => $tanggal_indonesia,
            'kaprodi' => $kaprodi,
        ]);
    	return $pdf->stream('laporan-rekap-nilai.pdf');
    }

    public function print_revisi($id)
    {
        set_time_limit(0);
        $ta = TugasAkhir::find($id);
        $revisi = Revisi::with(['uraian_revisi'])->where('tugas_akhir_id', $id)->get();
        $pembimbing = BimbingUji::with(['dosen'])->where('tugas_akhir_id', $id)->where('jenis','pembimbing')->where('urut', 1)->first();
        $pembimbing2 = BimbingUji::with(['dosen'])->where('tugas_akhir_id', $id)->where('jenis','pembimbing')->where('urut', 2)->first();
        $tanggal_indonesia = Carbon::now()->isoFormat('D MMMM YYYY');
        $pdf = PDF::loadview('mahasiswa-menu.pengajuan.print-revisi',[
            'ta' => $ta,
            'revisi' => $revisi,
            'pembimbing' => $pembimbing,
            'pembimbing2' => $pembimbing2,
            'tanggal' => $tanggal_indonesia,
        ]);
    	return $pdf->stream('laporan-revisi.pdf');
    }

    public function cekDosen(Request $request)
    {
        $periode = PeriodeTa::where('is_active', 1)->first();
        $kuota = KuotaDosen::where('dosen_id', $request->pemb_1)->where('periode_ta_id', $periode->id)->first();
            $bimbingUji = BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'pembimbing')->where('urut', 1)->where('dosen_id', $request->pemb_1)->whereHas('tugas_akhir', function ($q) use($periode){
                $q->where('periode_ta_id', $periode->id);
            })->count();

            if($bimbingUji >= $kuota->pemb_1){

                echo json_encode(1);

            }else{
                echo json_encode(0);
            }

    }

    public function printPembSatu($id){
        set_time_limit(0);
        // dd($id);
        $ta = TugasAkhir::find($id);
        $nilai = Nilai::where('tugas_akhir_id', $id)->get();
        $tanggal_indonesia = Carbon::now()->isoFormat('D MMMM YYYY');
        $pembimbing = BimbingUji::with(['dosen'])->where('tugas_akhir_id', $id)->where('jenis','pembimbing')->where('urut', 1)->first();
        // return view('mahasiswa-menu.pengajuan.print-nilai');
        $pdf = PDF::loadview('mahasiswa-menu.pengajuan.pemb_1',[
            'ta' => $ta,
            'pmb' => $pembimbing,
            'tanggal' => $tanggal_indonesia,
        ]);
    	return $pdf->stream('laporan-nilai.pdf');
    }
    public function printPembDua($id){
        set_time_limit(0);
        // dd($id);
        $ta = TugasAkhir::find($id);
        $nilai = Nilai::where('tugas_akhir_id', $id)->get();
        $tanggal_indonesia = Carbon::now()->isoFormat('D MMMM YYYY');
        $pembimbing = BimbingUji::with(['dosen'])->where('tugas_akhir_id', $id)->where('jenis','pembimbing')->where('urut', 2)->first();
        // return view('mahasiswa-menu.pengajuan.print-nilai');
        $pdf = PDF::loadview('mahasiswa-menu.pengajuan.pemb_2',[
            'ta' => $ta,
            'pmb' => $pembimbing,
            'tanggal' => $tanggal_indonesia,
        ]);
    	return $pdf->stream('laporan-nilai.pdf');
    }
}
