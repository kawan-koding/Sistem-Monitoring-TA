<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dosen;
use App\Models\KuotaDosen;
use App\Models\PeriodeTa;

class KuotaDosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('kuota_dosen.index', [
            "title" => "Kuota Dosen",
            "breadcrumb1" => "Kuota Dosen",
            "breadcrumb2" => "Index",
            "periode" => PeriodeTa::where('is_active', 1)->first(),
            'dataDosen'   => Dosen::all(),
            'jsInit'      => 'js_kuota_dosen.js',
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
        try {

            $data = KuotaDosen::where('dosen_id', $request->dosen_id)->where('periode_ta_id', $request->periode_ta_id)->first();

            if(isset($data->id)){
                KuotaDosen::where('dosen_id', $request->dosen_id)->where('periode_ta_id', $request->periode_ta_id)->update([
                    $request->field => $request->value,
                ]);
            }else{
                KuotaDosen::create([
                    'dosen_id' => $request->dosen_id,
                    'periode_ta_id' => $request->periode_ta_id,
                    $request->field => $request->value,
                ]);

            }

        } catch (\Exception $e) {

            return response()->json([
                'message' => $e->getMessage(),
            ], 200);
        }
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
