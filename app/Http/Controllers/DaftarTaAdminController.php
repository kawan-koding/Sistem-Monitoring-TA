<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\JenisTa;
use App\Models\Topik;
use App\Models\TugasAkhir;
use App\Models\PeriodeTa;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\BimbingUji;
use App\Models\KuotaDosen;

class DaftarTaAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('daftarta.index', [
            "title" => "Daftar TA",
            "breadcrumb1" => "Daftar TA",
            "breadcrumb2" => "Index",
            'dataTA'   => TugasAkhir::with(['jenis_ta', 'topik'])->where('status', '!=', 'draft')->get(),
            'jsInit'      => 'js_daftarta_admin.js',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function detail(string $id)
    {
        //
        return view('daftarta.detail', [
            "title" => "Daftar TA",
            "breadcrumb1" => "Daftar TA",
            "breadcrumb2" => "Detail",
            'data'        => TugasAkhir::find($id),
            'pembimbing1'  => BimbingUji::with(['dosen'])->where('jenis', 'pembimbing')->where('urut', 1)->where('tugas_akhir_id', $id)->first(),
            'pembimbing2'  => BimbingUji::with(['dosen'])->where('jenis', 'pembimbing')->where('urut', 2)->where('tugas_akhir_id', $id)->first(),
            'penguji1'  => BimbingUji::with(['dosen'])->where('jenis', 'penguji')->where('urut', 1)->where('tugas_akhir_id', $id)->first(),
            'penguji2'  => BimbingUji::with(['dosen'])->where('jenis', 'penguji')->where('urut', 2)->where('tugas_akhir_id', $id)->first(),
            'jsInit'      => 'js_daftarta_admin.js',
        ]);
    }

    public function show(string $id)
    {
        //
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
            $bimbingUji2 = BimbingUji::with(['tugas_akhir', 'dosen'])->where('dosen_id', $key->id)->where('jenis', 'pembimbing')->where('urut', 2)->whereHas('tugas_akhir', function ($q) use($periode){
                $q->where('periode_ta_id', $periode->id);
            })->count();
            $bimbingUji3 = BimbingUji::with(['tugas_akhir', 'dosen'])->where('dosen_id', $key->id)->where('jenis', 'penguji')->where('urut', 1)->whereHas('tugas_akhir', function ($q) use($periode){
                $q->where('periode_ta_id', $periode->id);
            })->count();
            $bimbingUji4 = BimbingUji::with(['tugas_akhir', 'dosen'])->where('dosen_id', $key->id)->where('jenis', 'penguji')->where('urut', 2)->whereHas('tugas_akhir', function ($q) use($periode){
                $q->where('periode_ta_id', $periode->id);
            })->count();
            // dd(10);
            $dosen[] = (object)[
                'nidn' => $key->nidn,
                'nama' => $key->name,
                'kuota_pemb_1' => ($kuota->pemb_1 ?? 0),
                'kuota_pemb_2' => ($kuota->pemb_2 ?? 0),
                'kuota_peng_1' => ($kuota->penguji_1 ?? 0),
                'kuota_peng_2' => ($kuota->penguji_2 ?? 0),
                'total_pemb_1' => $bimbingUji,
                'total_pemb_2' => $bimbingUji2,
                'total_peng_1' => $bimbingUji3,
                'total_peng_2' => $bimbingUji4,
            ];
        }
        return view('daftarta.form-edit', [
            "title" => "Daftar TA",
            "breadcrumb1" => "Daftar TA",
            "breadcrumb2" => "Edit",
            'dataJenis'   => JenisTa::all(),
            'dataTopik'   => Topik::all(),
            'data'        => TugasAkhir::find($id),
            'dataDosen'   => $dataDosen,
            'dosenKuota'   => $dosen,
            'bimbingUji'   => BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'pembimbing')->where('urut', 1)->where('tugas_akhir_id', $id)->first(),
            'bimbingUji2'   => BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'pembimbing')->where('urut', 2)->where('tugas_akhir_id', $id)->first(),
            'bimbingUji3'   => BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'penguji')->where('urut', 1)->where('tugas_akhir_id', $id)->first(),
            'bimbingUji4'   => BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'penguji')->where('urut', 2)->where('tugas_akhir_id', $id)->first(),
            'jsInit'      => 'js_daftarta_admin.js',
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
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

            //pembimbing 1
            $bimbingUji = BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'pembimbing')->where('urut', 1)->where('dosen_id', $request->pemb_1)->whereHas('tugas_akhir', function ($q) use($ta){
                $q->where('periode_ta_id', $ta->periode_ta_id);
            })->count();

            if($bimbingUji >= $kuota->pemb_1){

                return redirect()->back()->with('error', 'Kuota dosen pembimbing 1 yang di pilih telah mencapai batas');

            }

            //pembimbing 2
            $bimbingUji2 = BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'pembimbing')->where('urut', 2)->where('dosen_id', $request->pemb_2)->whereHas('tugas_akhir', function ($q) use($ta){
                $q->where('periode_ta_id', $ta->periode_ta_id);
            })->count();

            if($bimbingUji2 >= $kuota->pemb_2){

                return redirect()->back()->with('error', 'Kuota dosen pembimbing 2 yang di pilih telah mencapai batas');

            }

            //penguji 1
            $bimbingUji3 = BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'penguji')->where('urut', 1)->where('dosen_id', $request->peng_1)->whereHas('tugas_akhir', function ($q) use($ta){
                $q->where('periode_ta_id', $ta->periode_ta_id);
            })->count();

            if($bimbingUji3 >= $kuota->penguji_1){

                return redirect()->back()->with('error', 'Kuota dosen penguji 1 yang di pilih telah mencapai batas');

            }

            //penguji 2
            $bimbingUji4 = BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'penguji')->where('urut', 2)->where('dosen_id', $request->peng_2)->whereHas('tugas_akhir', function ($q) use($ta){
                $q->where('periode_ta_id', $ta->periode_ta_id);
            })->count();

            if($bimbingUji4 >= $kuota->penguji_2){

                return redirect()->back()->with('error', 'Kuota dosen penguji 2 yang di pilih telah mencapai batas');

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
            BimbingUji::where('tugas_akhir_id', $id)->where('jenis', 'pembimbing')->where('urut', 2)->update(
                [
                    'dosen_id' => $request->pemb_2,
                ]
            );
            BimbingUji::where('tugas_akhir_id', $id)->where('jenis', 'penguji')->where('urut', 1)->update(
                [
                    'dosen_id' => $request->peng_1,
                ]
            );
            BimbingUji::where('tugas_akhir_id', $id)->where('jenis', 'penguji')->where('urut', 2)->update(
                [
                    'dosen_id' => $request->peng_2,
                ]
            );
            return redirect()->route('admin.daftarta')->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {

            // dd($e->getMessage());
            return redirect()->route('admin.daftarta')->with('error', $e->getMessage())->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try{

            BimbingUji::where('tugas_akhir_id', $id)->delete();

            TugasAkhir::where('id', $id)->delete();

        }catch(\Exception $e){
            return redirect()->route('admin.daftarta')->with('error', $e->getMessage())->withInput($request->all());
        }
    }

    public function rekapitulasi(Request $request)
    {
        if(isset($request->status_ta)){
            $ta = TugasAkhir::with(['jenis_ta', 'topik']);
            if($request->status_ta == 1){
                $ta->where('status', 'draft');
            }
            if($request->status_ta == 2){
                $ta->where('status', 'acc');
            }
            if($request->status_ta == 3){
                $ta->where('status', 'acc');
                $telahJadwal = 1;
            }
            if($request->status_ta == 4){
                $ta->where('status', 'acc');
                $telahJadwal = 0;
            }
            $dataTa = $ta->get();
        }else{
            $dataTa = [];
        }
        return view('daftarta.rekapitulasi', [
            "title" => "Daftar TA",
            "breadcrumb1" => "Daftar TA",
            "breadcrumb2" => "Rekap",
            'dataTa'   => $dataTa,
            'telahJadwal'   => $telahJadwal ?? 0,
            'jsInit'      => 'js_daftarta_admin.js',
        ]);
    }
}
