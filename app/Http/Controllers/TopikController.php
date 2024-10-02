<?php

namespace App\Http\Controllers;

use App\Models\Topik;
use Illuminate\Http\Request;

class TopikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('topik.index', [
            "title" => "Topik",
            "breadcrumb1" => "Topik",
            "breadcrumb2" => "Index",
            'dataTopik'   => Topik::all(),
            'jsInit'      => 'js_topik.js',
        ]);
    }

    public function store(Request $request)
    {
        //
        try {
            // Potensi kode yang dapat menyebabkan pengecualian
            $result = Topik::create([
                'nama_topik' => $request->nama_topik
            ]);
            return redirect()->route('admin.topik')->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->route('admin.topik')->with('error', $e->getMessage());
        }
    }

    public function show(string $id)
    {
        $topik = Topik::find($id);
        echo json_encode($topik);
    }

    public function update(Request $request)
    {
        //
        try {
            // Potensi kode yang dapat menyebabkan pengecualian
            $result = Topik::where('id', $request->id)->update([
                'nama_topik' => $request->nama_topik
            ]);
            return redirect()->route('admin.topik')->with('success', 'Data berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->route('admin.topik')->with('error', $e->getMessage());
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
            Topik::where('id', $id)->delete();

        } catch (\Exception $e) {


            return redirect()->route('admin.topik')->with('error', $e->getMessage());
        }
    }
}
