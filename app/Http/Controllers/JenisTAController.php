<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisTa;

class JenisTAController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('jenis_ta.index', [
            "title" => "Jenis TA",
            "breadcrumb1" => "Jenis TA",
            "breadcrumb2" => "Index",
            'dataJenis'   => JenisTa::all(),
            'jsInit'      => 'js_jenis_ta.js',
        ]);
    }


    public function store(Request $request)
    {
        //
        try {
            // Potensi kode yang dapat menyebabkan pengecualian
            $result = JenisTa::create([
                'nama_jenis' => $request->nama_jenis
            ]);
            return redirect()->route('admin.jenis_ta')->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {

            // dd($e->getMessage());
            return redirect()->route('admin.jenis_ta')->with('error', $e->getMessage());
        }
    }

    public function show(string $id)
    {
        //
        $jenis = JenisTa::find($id);

        echo json_encode($jenis);
    }

    public function update(Request $request)
    {
        //
        try {
            // Potensi kode yang dapat menyebabkan pengecualian
            $result = JenisTa::where('id', $request->id)->update([
                'nama_jenis' => $request->nama_jenis
            ]);
            return redirect()->route('admin.jenis_ta')->with('success', 'Data berhasil diupdate');
        } catch (\Exception $e) {

            // dd($e->getMessage());
            return redirect()->route('admin.jenis_ta')->with('error', $e->getMessage());
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
            JenisTa::where('id', $id)->delete();

        } catch (\Exception $e) {

            // dd($e->getMessage());
            return redirect()->route('admin.jenis_ta')->with('error', $e->getMessage());
        }
    }
}
