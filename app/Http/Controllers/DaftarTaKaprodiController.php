<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TugasAkhir;
use App\Models\BimbingUji;

class DaftarTaKaprodiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('kaprodi-menu.daftarta.index', [
            "title" => "Daftar TA",
            "breadcrumb1" => "Daftar TA",
            "breadcrumb2" => "Index",
            'dataTA'   => TugasAkhir::with(['jenis_ta', 'topik'])->get(),
            'jsInit'      => 'js_daftarta_kaprodi.js',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function show(string $id)
    {
        //

        return view('kaprodi-menu.daftarta.detail', [
            "title" => "Daftar TA",
            "breadcrumb1" => "Daftar TA",
            "breadcrumb2" => "Detail",
            'data'        => TugasAkhir::find($id),
            'pembimbing1'  => BimbingUji::with(['dosen'])->where('jenis', 'pembimbing')->where('urut', 1)->where('tugas_akhir_id', $id)->first(),
            'pembimbing2'  => BimbingUji::with(['dosen'])->where('jenis', 'pembimbing')->where('urut', 2)->where('tugas_akhir_id', $id)->first(),
            'penguji1'  => BimbingUji::with(['dosen'])->where('jenis', 'penguji')->where('urut', 1)->where('tugas_akhir_id', $id)->first(),
            'penguji2'  => BimbingUji::with(['dosen'])->where('jenis', 'penguji')->where('urut', 2)->where('tugas_akhir_id', $id)->first(),
            'jsInit'      => 'js_daftarta_kaprodi.js',
        ]);
    }

    public function store(Request $request)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
