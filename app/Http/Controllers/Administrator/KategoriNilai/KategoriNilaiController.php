<?php

namespace App\Http\Controllers\Administrator\KategoriNilai;

use Illuminate\Http\Request;
use App\Models\KategoriNilai;
use App\Http\Controllers\Controller;

class KategoriNilaiController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Kategori Nilai',
            'mods' => 'kategori_nilai',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Master Data',
                    'is_active' => true
                ],
                [
                    'title' => 'Kategori Nilai',
                    'is_active' => true, 
                ]
            ],
            'data' => KategoriNilai::all(),
        ];

        return view('administrator.kategori-nilai.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required'
        ],[
            'nama.required' =>  'Nama harus diisi',
        ]);
        try {
            $result = KategoriNilai::create($request->only(['nama']));
            return redirect()->back()->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show(KategoriNilai $kategoriNilai)
    {
        // dd($kategoriNilai);
        return response()->json($kategoriNilai);
    }

    public function update(Request $request, KategoriNilai $kategoriNilai)
    {
        $request->validate([
            'nama' => 'required'
        ],[
            'nama.required' =>  'Nama harus diisi',
        ]);   
        try {
            $kategoriNilai->update($request->only(['nama']));
            return redirect()->route('apps.kategori-nilai')->with('success', 'Data berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriNilai $kategoriNilai)
    {
        try {
            $kategoriNilai->delete();
            return $this->successResponse('Berhasil menghapus data');
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }
}
