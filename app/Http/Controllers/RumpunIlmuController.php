<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RumpunIlmu;
use App\Models\Dosen;
use Illuminate\Support\Facades\Auth;

class RumpunIlmuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $dos = Dosen::where('nidn', Auth::guard('web')->user()->username)->first();
        // dd($dos->id);
        return view('rumpunilmu.index', [
            "title" => "Rumpun Ilmu",
            "breadcrumb1" => "Rumpun Ilmu",
            "breadcrumb2" => "Index",
            'dataRumpunIlmu'   => RumpunIlmu::where('dosen_id', $dos->id)->get(),
            'jsInit'      => 'js_rumpun_ilmu.js',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        try{
            $dos = Dosen::where('nidn', Auth::guard('web')->user()->username)->first();
            RumpunIlmu::create([
                'nama' => $request->nama,
                'dosen_id' => $dos->id,
            ]);
            return redirect()->route('dosen.rumpun-ilmu')->with('success', 'Berhasil menambah data!');
        }catch(\Exception $e){
            return redirect()->route('dosen.rumpun-ilmu')->with('error', $e->getMessage());
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
        $data = RumpunIlmu::find($id);

        echo json_encode($data);
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
    public function update(Request $request)
    {
        //
        try {
            // Potensi kode yang dapat menyebabkan pengecualian
            $result = RumpunIlmu::where('id', $request->id)->update([
                'nama' => $request->nama
            ]);
            return redirect()->route('dosen.rumpun-ilmu')->with('success', 'Data berhasil diupdate');
        } catch (\Exception $e) {

            // dd($e->getMessage());
            return redirect()->route('dosen.rumpun-ilmu')->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Potensi kode yang dapat menyebabkan pengecualian
            RumpunIlmu::where('id', $id)->delete();

        } catch (\Exception $e) {

            // dd($e->getMessage());
            return redirect()->route('dosen.rumpun-ilmu')->with('error', $e->getMessage());
        }
    }
}
