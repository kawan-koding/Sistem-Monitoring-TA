<?php

namespace App\Http\Controllers\Administrator\KuotaDosen;

use App\Models\Dosen;
use App\Models\PeriodeTa;
use App\Models\KuotaDosen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KuotaDosenController extends Controller
{
    public function index()
    {
        $dosen = Dosen::all(); 
        $periode = PeriodeTa::where('is_active', true)->first();
        $data = [
            'title' => 'Kuota Dosen',
            'mods' => 'kuota_dosen',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Kuota Dosen',
                    'is_active' => true
                ]
            ],
            'data' => $dosen,
            'periode' => $periode,
        ];

        return view('administrator.kuota-dosen.index', $data);
    }
    
    public function store(Request $request)
    {
        try {
            $data = KuotaDosen::where('dosen_id', $request->dosen_id)->where('periode_ta_id', $request->periode_ta_id)->first();
            if(isset($data->id)){
                $data->update([
                    $request->field => $request->value,
                ]);
            } else {
                KuotaDosen::create([
                    'dosen_id' => $request->dosen_id,
                    'periode_ta_id' => $request->periode_ta_id,
                    $request->field => $request->value,
                ]);
            }
            return $this->successResponse('Data berhasil disimpan');
        } catch(Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function createAll(Request $request)
    {
        $request->validate([
            'pembimbing_1' => 'required',
            'pembimbing_2' => 'required',
            'penguji_1' => 'required',
            'penguji_2' => 'required'
        ],[
            'pembimbing_1' => 'Kuota Pembimbing 1 wajib diisi',
            'pembimbing_1' => 'Kuota Pembimbing 2 wajib diisi',
            'penguji_1' => 'Kuota Penguji 1 wajib diisi',
            'penguji_2' => 'Kuota Penguji 2 wajib diisi',
        ]);

        try {
            $dosen = Dosen::all();
            $periode = PeriodeTa::where('is_active', true)->first();
            foreach($dosen as $item) {
                $existingKuota = KuotaDosen::where('dosen_id', $item->id)->where('periode_ta_id', $periode->id)->first();
                if(!$existingKuota) {
                    $request->merge(['dosen_id' => $item->id,'periode_ta_id' => $periode->id]);
                    $kuota  = KuotaDosen::create($request->only(['dosen_id', 'periode_ta_id', 'pembimbing_1', 'pembimbing_2', 'penguji_1', 'penguji_2']));
                }
            }

            return redirect()->route('apps.kuota-dosen')->with('success', 'Berhasil menyimpan data');
        } catch (\Exception $e) {
            return redirect()->back()->with($e->getMessage());
        }
    }
}
