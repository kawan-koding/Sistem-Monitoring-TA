<?php

namespace App\Http\Controllers\Administrator\Ruangan;

use App\Models\Ruangan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            "title" => "Ruangan",
            'mods' => 'ruangan',
            'breadcrumb' => [
                [
                    'title' => "Dashboard",
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => "Master Data",
                    'is_active' => true,
                ],
                [
                    'title' => "Ruangan",
                    'is_active' => true
                ]
            ],
            'dataRuangan'   => Ruangan::all(),
        ];
        
        return view('administrator.ruangan.index', $data);
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
            return redirect()->route('apps.ruangan')->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {

            return redirect()->route('apps.ruangan')->with('error', $e->getMessage());
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
            return redirect()->route('apps.ruangan')->with('success', 'Data berhasil diupdate');
        } catch (\Exception $e) {


            return redirect()->route('apps.ruangan')->with('error', $e->getMessage());
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
            return $this->successResponse('Berhasil menghapus data');
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }
}
