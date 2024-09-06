<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ruangan;

class RuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('ruangan.index', [
            "title" => "Ruangan",
            "breadcrumb1" => "Ruangan",
            "breadcrumb2" => "Index",
            'dataRuangan'   => Ruangan::all(),
            'jsInit'      => 'js_ruangan.js',
        ]);
    }


    public function store(Request $request)
    {
        //
        try {
            // Potensi kode yang dapat menyebabkan pengecualian
            $result = Ruangan::create([
                'kode' => $request->kode,
                'nama_ruangan' => $request->nama_ruangan,
                'lokasi' => $request->lokasi,
            ]);
            return redirect()->route('admin.ruangan')->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {

            // dd($e->getMessage());
            return redirect()->route('admin.ruangan')->with('error', $e->getMessage());
        }
    }

    public function show(string $id)
    {
        //
        $data = Ruangan::find($id);

        echo json_encode($data);
    }

    public function update(Request $request)
    {
        //
        try {
            // Potensi kode yang dapat menyebabkan pengecualian
            $result = Ruangan::where('id', $request->id)->update([
                'kode' => $request->kode,
                'nama_ruangan' => $request->nama_ruangan,
                'lokasi' => $request->lokasi,
            ]);
            return redirect()->route('admin.ruangan')->with('success', 'Data berhasil diupdate');
        } catch (\Exception $e) {


            return redirect()->route('admin.ruangan')->with('error', $e->getMessage());
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
            Ruangan::where('id', $id)->delete();

        } catch (\Exception $e) {


            return redirect()->route('admin.ruangan')->with('error', $e->getMessage());
        }
    }
}
