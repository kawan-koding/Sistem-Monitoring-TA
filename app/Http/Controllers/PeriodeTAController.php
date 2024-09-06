<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeriodeTa;

class PeriodeTAController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('periode.index', [
            "title" => "Periode TA",
            "breadcrumb1" => "Periode TA",
            "breadcrumb2" => "Index",
            'dataPeriod'   => PeriodeTa::all(),
            'jsInit'      => 'js_periode.js',
        ]);
    }


    public function store(Request $request)
    {
        //
        try {
            // Potensi kode yang dapat menyebabkan pengecualian
            $result = PeriodeTa::create([
                'nama' => $request->nama,
                'mulai_daftar' => $request->mulai_daftar,
                'akhir_daftar' => $request->akhir_daftar,
                'mulai_seminar' => $request->mulai_seminar,
                'akhir_seminar' => $request->akhir_seminar,
                'is_active' => 0,
            ]);
            return redirect()->route('admin.periode')->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {

            // dd($e->getMessage());
            return redirect()->route('admin.periode')->with('error', $e->getMessage());
        }
    }

    public function show(string $id)
    {
        //
        $topik = PeriodeTa::find($id);

        echo json_encode($topik);
    }

    public function update(Request $request)
    {
        //
        try {
            // Potensi kode yang dapat menyebabkan pengecualian
            $result = PeriodeTa::where('id', $request->id)->update([
                'nama' => $request->nama,
                'mulai_daftar' => $request->mulai_daftar,
                'akhir_daftar' => $request->akhir_daftar,
                'mulai_seminar' => $request->mulai_seminar,
                'akhir_seminar' => $request->akhir_seminar,
            ]);
            return redirect()->route('admin.periode')->with('success', 'Data berhasil diupdate');
        } catch (\Exception $e) {


            return redirect()->route('admin.periode')->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try {
            // Potensi kode yang dapat menyebabkan pengecualian
            PeriodeTa::where('id', $id)->delete();

        } catch (\Exception $e) {


            return redirect()->route('admin.periode')->with('error', $e->getMessage());
        }
    }

    public function change($id, Request $request){
        try {
            // Potensi kode yang dapat menyebabkan pengecualian
            // dd($request->is);
            PeriodeTa::where('is_active', 1)->update([
                'is_active' => 0,
            ]);

            PeriodeTa::where('id', $id)->update([
                'is_active' => $request->is,
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'message' => $e->getMessage(),
            ], 200);
        }
    }
}
