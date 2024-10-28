<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\TugasAkhir;
use App\Models\BimbingUji;
use App\Models\PeriodeTa;
use App\Models\Dosen;
use App\Models\Revisi;
use App\Models\UraianRevisi;

class DaftarBimbinganDosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
            
        $myId = Auth::guard('web')->user()->id;
        $periode = PeriodeTa::where('is_active', 1)->first();

        $bimbingan = BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'pembimbing')->whereHas('dosen', function($q)use($myId){
            $q->where('user_id', $myId);
        })->whereHas('tugas_akhir', function($q)use($periode){
            $q->where('periode_ta_id', $periode->id);
        })->get();
        $uji = BimbingUji::with(['tugas_akhir', 'dosen'])->where('jenis', 'penguji')->whereHas('dosen', function($q)use($myId){
            $q->where('user_id', $myId);
        })->whereHas('tugas_akhir', function($q)use($periode){
            $q->where('periode_ta_id', $periode->id);
        })->get();

        return view('dosen-menu.daftar-bimbingan.index', [
            "title" => "Daftar Bimbingan",
            "breadcrumb1" => "Daftar Bimbingan",
            "breadcrumb2" => "Index",
            'dataBimbingan'   => $bimbingan,
            'dataUji'   => $uji,
            'jenis_'   => ($request->jenis ?? null),
            'jsInit'      => 'js_daftarbimbingan_dosen.js',
        ]);
    }

    public function show_bimbingan(string $id)
    {
        return view('dosen-menu.daftar-bimbingan.detail-bimbingan', [
            "title" => "Daftar Bimbingan",
            "breadcrumb1" => "Daftar Bimbingan",
            "breadcrumb2" => "Detail Mahasiswa Bimbingan",
            'data'        => TugasAkhir::find($id),
            'pembimbing1'  => BimbingUji::with(['dosen'])->where('jenis', 'pembimbing')->where('urut', 1)->where('tugas_akhir_id', $id)->first(),
            'pembimbing2'  => BimbingUji::with(['dosen'])->where('jenis', 'pembimbing')->where('urut', 2)->where('tugas_akhir_id', $id)->first(),
            'penguji1'  => BimbingUji::with(['dosen'])->where('jenis', 'penguji')->where('urut', 1)->where('tugas_akhir_id', $id)->first(),
            'penguji2'  => BimbingUji::with(['dosen'])->where('jenis', 'penguji')->where('urut', 2)->where('tugas_akhir_id', $id)->first(),
            'jsInit'      => 'js_daftarbimbingan_dosen.js',
        ]);
    }

    public function show_uji(string $id)
    {
        return view('dosen-menu.daftar-bimbingan.detail-uji', [
            "title" => "Daftar Bimbingan",
            "breadcrumb1" => "Daftar Bimbingan",
            "breadcrumb2" => "Detail Uji",
            'data'        => TugasAkhir::find($id),
            'pembimbing1'  => BimbingUji::with(['dosen'])->where('jenis', 'pembimbing')->where('urut', 1)->where('tugas_akhir_id', $id)->first(),
            'pembimbing2'  => BimbingUji::with(['dosen'])->where('jenis', 'pembimbing')->where('urut', 2)->where('tugas_akhir_id', $id)->first(),
            'penguji1'  => BimbingUji::with(['dosen'])->where('jenis', 'penguji')->where('urut', 1)->where('tugas_akhir_id', $id)->first(),
            'penguji2'  => BimbingUji::with(['dosen'])->where('jenis', 'penguji')->where('urut', 2)->where('tugas_akhir_id', $id)->first(),
            'jsInit'      => 'js_daftarbimbingan_dosen.js',
        ]);
    }

    public function show_revisi(string $id)
    {
        $myId = Auth::guard('web')->user()->id;
        $dosen = Dosen::where('user_id', $myId)->first();
        $bimbingan = BimbingUji::with(['tugas_akhir', 'dosen'])->where('tugas_akhir_id', $id)->where('dosen_id', $dosen->id)->first();

        if(isset($bimbingan->id)){
            $tipe = $bimbingan->jenis;
            $urut = $bimbingan->urut;
        }

        $revisi = UraianRevisi::with(['revisi'])->whereHas('revisi', function($q)use($dosen, $id){
            $q->where('dosen_id', $dosen->id)->where('tugas_akhir_id', $id);
        })->get();

        return view('dosen-menu.daftar-bimbingan.revisi', [
            "title" => "Daftar Bimbingan",
            "breadcrumb1" => "Daftar Bimbingan",
            "breadcrumb2" => "Revisi",
            'data'        => $revisi,
            'jsInit'      => 'js_daftarbimbingan_dosen.js',
        ]);
    }

    public function status_revisi(Request $request, string $id)
    {
        // dd($request->all());
        try{
            UraianRevisi::where('id', $request->id)->update([
                'status' => $request->status_revisi
            ]);

            return redirect()->back()->with('success', 'Berhasil update status');
        }catch(\Exception $e){

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, string $id)
    {
        //
    }

}
