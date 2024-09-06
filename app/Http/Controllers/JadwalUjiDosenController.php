<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\PeriodeTa;
use App\Models\TugasAkhir;
use App\Models\BimbingUji;
use App\Models\Dosen;
use App\Models\Revisi;
use App\Models\UraianRevisi;
use App\Models\JadwalSeminar;
use App\Models\Nilai;
use App\Models\DetailNilai;

class JadwalUjiDosenController extends Controller
{
    //
    public function index(Request $request)
    {
        $myId = Auth::guard('web')->user()->id;
        $periode = PeriodeTa::where('is_active', 1)->first();

        $bimbingan = BimbingUji::with(['tugas_akhir', 'dosen'])->whereHas('dosen', function($q)use($myId){
            $q->where('user_id', $myId);
        })->whereHas('tugas_akhir', function($q)use($periode){
            $q->where('periode_ta_id', $periode->id);
        })->get();

        return view('dosen-menu.jadwal-uji.index', [
            "title" => "Jadwal Uji",
            "breadcrumb1" => "Jadwal Uji",
            "breadcrumb2" => "Index",
            'dataUji'   => $bimbingan,
            'tgl'   => $request->tanggal ?? null,
            'jsInit'      => 'js_jadwaluji_dosen.js',
        ]);
    }

    public function show($id)
    {
        date_default_timezone_set('Asia/Jakarta');
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

        $nilai = DetailNilai::with(['nilai'])->whereHas('nilai', function($q)use($dosen, $id){
            $q->where('dosen_id', $dosen->id)->where('tugas_akhir_id', $id);
        })->get();

        $seminar = JadwalSeminar::where('tugas_akhir_id', $id)->first();
        if ($seminar) {
            $waktu_sekarang = date('H:i:s');
            $tgl_sekarang = date('Y-m-d');
            if (($waktu_sekarang >= $seminar->jam_mulai && $tgl_sekarang == $seminar->tanggal) || $tgl_sekarang > $seminar->tanggal) {
                $waktu = 'berlangsung';
            } else {
                $waktu = 'tidak berlangsung';
            }
        } else {
            $waktu = 'seminar tidak ditemukan';
        }
        // dd($waktu);
        return view('dosen-menu.jadwal-uji.detail', [
            "title" => "Jadwal Uji",
            "breadcrumb1" => "Jadwal Uji",
            "breadcrumb2" => "Detail",
            'dataUji'   => [],
            'tipeDosen'   => $tipe,
            'urutDosen'   => $urut,
            'dataDosen'   => $dosen,
            'dataBimbingan'   => $bimbingan ?? [],
            'revisi'   => $revisi,
            'nilai'   => $nilai,
            'timer'   => $waktu,
            'jsInit'      => 'js_jadwaluji_dosen.js',
        ]);
    }

    public function create_revisi(Request $request)
    {
        try {
            $rev = Revisi::where('dosen_id', $request->dosen_id)->where('tugas_akhir_id', $request->tugas_akhir_id)->first();

            if(isset($rev->id)){
                $result = $rev;
                // dd($result);
            }else{
                $result = Revisi::create([
                    'dosen_id' => $request->dosen_id,
                    'tugas_akhir_id' => $request->tugas_akhir_id,
                ]);
                // dd($result);
            }

            UraianRevisi::create([
                'revisi_id' => $result->id,
                'uraian' => $request->uraian,
                'status' => 0,
            ]);

            return redirect()->back()->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {

            // dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function delete_uraian($id)
    {
        try{
            UraianRevisi::where('id', $id)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Delete data success',
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function create_nilai(Request $request){
        // dd($request->all());
        try{
            $nilai = Nilai::where('dosen_id', $request->dosen_id)->where('tugas_akhir_id', $request->tugas_akhir_id)->first();

            if(isset($nilai->id)){
                $result = $nilai;
            }else{
                $result = Nilai::create([
                    'dosen_id' => $request->dosen_id,
                    'tugas_akhir_id' => $request->tugas_akhir_id,
                    'jenis' => $request->jenis,
                    'urut' => $request->urut,
                ]);
            }

            // dd($result->id);
            // KRITERIA NILAI
            if($request->nilai >= 81){
                $nHuruf = 'A';
            }else if($request->nilai >= 75){
                $nHuruf = 'AB';
            }else if($request->nilai >= 65){
                $nHuruf = 'B';
            }else if($request->nilai >= 60){
                $nHuruf = 'BC';
            }else if($request->nilai >= 55){
                $nHuruf = 'C';
            }else if($request->nilai >= 40){
                $nHuruf = 'D';
            }else if($request->nilai < 40){
                $nHuruf = 'E';
            }

            $dN = DetailNilai::where('nilai_id', $result->id)->where('aspek', $request->aspek)->first();
            // dd($dN);

            if(!isset($dN->id)){
                DetailNilai::create([
                    'nilai_id' => $result->id,
                    'aspek' => $request->aspek,
                    'angka' => $request->nilai,
                    'huruf' => $nHuruf,
                ]);
            }else{
                DetailNilai::where('id', $dN->id)->update([
                    'nilai_id' => $result->id,
                    'aspek' => $request->aspek,
                    'angka' => $request->nilai,
                    'huruf' => $nHuruf,
                ]);

            }

            echo $nHuruf;
        }catch(\Exception $e){
            // return redirect()->back()->with('error', $e->getMessage());
            echo $e->getMessage();
        }
    }

    public function delete_nilai($id)
    {
        try{
            DetailNilai::where('id', $id)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Delete data success',
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update_status_seminar(Request $request)
    {
        try{
            TugasAkhir::where('id', $request->id)->update([
                'status_seminar' => $request->status_seminar
            ]);

            return redirect()->back()->with('success', 'Berhasil update status');
        }catch(\Exception $e){

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update_revisi(Request $request)
    {
        try{
            UraianRevisi::where('id', $request->id)->update([
                'uraian' => $request->uraian,
            ]);

            return redirect()->back()->with('success', 'Berhasil update status');
        }catch(\Exception $e){

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
