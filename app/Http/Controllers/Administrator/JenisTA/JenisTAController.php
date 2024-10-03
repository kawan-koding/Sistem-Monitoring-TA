<?php

namespace App\Http\Controllers\Administrator\JenisTA;

use App\Models\JenisTa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JenisTAController extends Controller
{
    public function index()
    {
        
         $data = [
            'title' => 'Jenis Tugas Akhir',
            'mods' => 'jenis_ta',
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
                    'title' => 'Jenis Tugas Akhir',
                    'is_active' => true, 
                ]
            ],
            'dataJenis' => JenisTa::all(),
        ];

        return view('administrator.jenis-ta.index', $data);
    }


    public function store(Request $request)
    {
        //
        try {
            // Potensi kode yang dapat menyebabkan pengecualian
            $result = JenisTa::create([
                'nama_jenis' => $request->nama_jenis
            ]);
            return redirect()->route('apps.jenis-ta')->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {

            // dd($e->getMessage());
            return redirect()->route('apps.jenis-ta')->with('error', $e->getMessage());
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
            $result = JenisTa::where('id', $request->id)->update([
                'nama_jenis' => $request->nama_jenis
            ]);
            return redirect()->route('apps.jenis-ta')->with('success', 'Data berhasil diupdate');
        } catch (\Exception $e) {

            // dd($e->getMessage());
            return redirect()->route('apps.jenis-ta')->with('error', $e->getMessage());
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
            return redirect()->route('apps.jenis-ta')->with('error', $e->getMessage());
        }
    }
}
