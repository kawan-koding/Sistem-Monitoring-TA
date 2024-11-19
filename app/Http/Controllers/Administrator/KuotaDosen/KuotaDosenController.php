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
    
    // public function store(Request $request)
    // {
    //     try {
    //         $data = KuotaDosen::where('dosen_id', $request->dosen_id)->where('periode_ta_id', $request->periode_ta_id)->first();
    //         if(isset($data->id)){
    //             $data->update([
    //                 $request->field => $request->value,
    //             ]);
    //         } else {
    //             KuotaDosen::create([
    //                 'dosen_id' => $request->dosen_id,
    //                 'periode_ta_id' => $request->periode_ta_id,
    //                 $request->field => $request->value,
    //             ]);
    //         }
    //         return $this->successResponse('Data berhasil disimpan');
    //     } catch(Exception $e) {
    //         return $this->exceptionResponse($e);
    //     }
    // }

    
    public function show($id)
    {
        $dsn = Dosen::findOrFail($id);
        $periode = PeriodeTa::where('is_active', true)->first();
        $kuotaDosen = KuotaDosen::where('dosen_id', $dsn->id)->where('periode_ta_id', $periode->id)->first();

        return response()->json($kuotaDosen);
    }

    public function update(Request $request)
    {
        $request->validate([
           'pembimbing_1' => 'nullable',
           'pembimbing_2' => 'nullable',
           'penguji_1' => 'nullable',
           'penguji_2' => 'nullable',
           'dosen_id' => 'required',
        ]);

        try {
            $periode = PeriodeTa::where('is_active', true)->first();
            $data = KuotaDosen::where('dosen_id', $request->dosen_id)->where('periode_ta_id', $periode->id)->first();
            $fields = $request->only(['pembimbing_1', 'pembimbing_2', 'penguji_1', 'penguji_2']); 

            if(isset($data->id)) {
                $data->update($fields);
            } else {
                KuotaDosen::create(array_merge(
                    ['dosen_id' => $request->dosen_id,'periode_ta_id' => $periode->id,],
                    $fields
                ));
            }
            return redirect()->back()->with('success', 'Data berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
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
                $existingKuota = KuotaDosen::where('dosen_id', $item->id)->where('periode_ta_id', $periode->id)->exists();
                if (!$existingKuota) {
                    KuotaDosen::create([
                        'dosen_id' => $item->id,
                        'periode_ta_id' => $periode->id,
                        'pembimbing_1' => $request->pembimbing_1,
                        'pembimbing_2' => $request->pembimbing_2,
                        'penguji_1' => $request->penguji_1,
                        'penguji_2' => $request->penguji_2,
                    ]);
                }
            }

            return redirect()->route('apps.kuota-dosen')->with('success', 'Berhasil menyimpan data');
        } catch (\Exception $e) {
            return redirect()->back()->with($e->getMessage());
        }
    }
}
