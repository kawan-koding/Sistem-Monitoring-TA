<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\PeriodeTa;
use App\Models\TugasAkhir;
use App\Models\Mahasiswa;
use App\Models\BimbingUji;
use App\Models\Revisi;
use App\Models\UraianRevisi;
use App\Models\Nilai;
use App\Models\DetailNilai;
use App\Models\JadwalSeminar;

class JadwalSeminarMahasiswaController extends Controller
{
    //
    public function index()
    {
        $myId = Auth::guard('web')->user()->id;
        $periode = PeriodeTa::where('is_active', 1)->first();
        $mhs = Mahasiswa::where('user_id', $myId)->first();

        $jadwal = JadwalSeminar::with(['tugas_akhir', 'ruangan'])->whereHas('tugas_akhir', function($q)use($periode, $mhs){
            $q->where('periode_ta_id', $periode->id)->where('mahasiswa_id', $mhs->id);
        })->get();
        // dd($jadwal);
        return view('mahasiswa-menu.jadwal-uji.index', [
            "title" => "Jadwal Seminar",
            "breadcrumb1" => "Jadwal Seminar",
            "breadcrumb2" => "Index",
            'dataUji'   => $jadwal,
            'jsInit'      => 'js_jadwal_seminar.js',
        ]);
    }

    public function show($id)
    {
        $tugas_akhir = TugasAkhir::find($id);
        //penguji1
        $penguji1 = BimbingUji::with(['dosen'])->where('tugas_akhir_id', $id)->where('jenis', 'penguji')->where('urut', 1)->first();
        $revisi_penguji_1 = UraianRevisi::with(['revisi'])->whereHas('revisi', function($q)use($id, $penguji1){
            $q->where('tugas_akhir_id', $id)->where('dosen_id', $penguji1->dosen_id);
        })->get();
        //penguji2
        $penguji2 = BimbingUji::with(['dosen'])->where('tugas_akhir_id', $id)->where('jenis', 'penguji')->where('urut', 2)->first();
        $revisi_penguji_2 = UraianRevisi::with(['revisi'])->whereHas('revisi', function($q)use($id, $penguji2){
            $q->where('tugas_akhir_id', $id)->where('dosen_id', $penguji2->dosen_id);
        })->get();

        // Nilai Pembimbing 1
        $nilai_pemb_1 = DetailNilai::with(['nilai'])->whereHas('nilai', function($q)use($id){
            $q->where('tugas_akhir_id', $id)->where('jenis', 'pembimbing')->where('urut', 1);
        })->get();
        // Nilai Pembimbing 2
        $nilai_pemb_2 = DetailNilai::with(['nilai'])->whereHas('nilai', function($q)use($id){
            $q->where('tugas_akhir_id', $id)->where('jenis', 'pembimbing')->where('urut', 2);
        })->get();
        // Nilai penguji 1
        $nilai_peng_1 = DetailNilai::with(['nilai'])->whereHas('nilai', function($q)use($id){
            $q->where('tugas_akhir_id', $id)->where('jenis', 'penguji')->where('urut', 1);
        })->get();
        // Nilai penguji 2
        $nilai_peng_2 = DetailNilai::with(['nilai'])->whereHas('nilai', function($q)use($id){
            $q->where('tugas_akhir_id', $id)->where('jenis', 'penguji')->where('urut', 2);
        })->get();
        // dd($penguji1);
        return view('mahasiswa-menu.jadwal-uji.detail', [
            "title" => "Jadwal Seminar",
            "breadcrumb1" => "Jadwal Seminar",
            "breadcrumb2" => "Detail",
            'revisi_penguji_1'   => $revisi_penguji_1,
            'penguji1'   => $penguji1,
            'revisi_penguji_2'   => $revisi_penguji_2,
            'penguji2'   => $penguji2,
            'nilai_pemb_1'   => $nilai_pemb_1,
            'nilai_pemb_2'   => $nilai_pemb_2,
            'nilai_peng_1'   => $nilai_peng_1,
            'nilai_peng_2'   => $nilai_peng_2,
            'jsInit'      => 'js_jadwal_seminar.js',
        ]);
    }
}
