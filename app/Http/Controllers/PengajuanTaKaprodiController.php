<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TugasAkhir;
use App\Models\Mahasiswa;
use App\Models\PeriodeTa;

class PengajuanTaKaprodiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $periode = PeriodeTa::where('is_active', 1)->first();
        return view('kaprodi-menu.pengajuan.index', [
            "title" => "Pengajuan TA",
            "breadcrumb1" => "Pengajuan TA",
            "breadcrumb2" => "Index",
            'dataTA'   => TugasAkhir::with(['jenis_ta', 'topik'])->where('periode_ta_id', $periode->id)->where('status', 'draft')->get(),
            'jsInit'      => 'js_jadwal_bimbingan_kaprodi.js',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function acc($id)
    {
        //
        try {
            // Potensi kode yang dapat menyebabkan pengecualian
            TugasAkhir::where('id', $id)->update([
                'status' => 'acc',
            ]);

            return response()->json((object)[
                'message' => 'Berhasil di acc',
                'status' => 'success',
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error',
            ], 500);
        }
    }

    public function reject($id, Request $request)
    {
        //
        try {
            // Potensi kode yang dapat menyebabkan pengecualian
            TugasAkhir::where('id', $id)->update([
                'status' => 'reject',
                'catatan' => $request->catatan,
            ]);

            return redirect()->back()->with('success', 'Data telah di reject');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
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
