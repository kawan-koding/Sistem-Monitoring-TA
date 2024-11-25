<?php

namespace App\Http\Controllers\Administrator\KuotaDosen;

use App\Models\Dosen;
use App\Models\PeriodeTa;
use App\Models\KuotaDosen;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KuotaDosenController extends Controller
{
    public function index(Request $request)
    {
        $periode = PeriodeTa::where('is_active', true)->first();
        $query = KuotaDosen::where('periode_ta_id', $periode->id)->with(['dosen']);
        if(session('switchRoles') == 'Admin') {
            if ($request->has('program_studi') && !empty($request->program_studi) && $request->program_studi !== 'semua') {
                $query->where('program_studi_id', $request->program_studi);
            }
        }
        
        if(session('switchRoles') == 'Kaprodi') {
            $user = getInfoLogin()->userable;
            $prodi = $user->programStudi;
            $query->where('program_studi_id', $prodi->id);
        }

        $query = $query->get();

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
            'data' => $query,
            'prodi' => ProgramStudi::all(),
            'periode' => $periode,
        ];
        return view('administrator.kuota-dosen.index', $data);
    }

    public function show(KuotaDosen $kuotaDosen)
    {
        return response()->json($kuotaDosen);
    }

    public function update(KuotaDosen $kuotaDosen, Request $request)
    {
        $request->validate([
            'dosen_id' => 'required',
            'pembimbing_1' => 'nullable',
            'pembimbing_2' => 'nullable',
            'penguji_1' => 'nullable',
            'penguji_2' => 'nullable',
        ]);

        try {
            $kuotaDosen->update($request->only(['pembimbing_1', 'pembimbing_2', 'penguji_1', 'penguji_2']));
            return redirect()->back()->with('success', 'Data berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function createAll(Request $request)
    {        
        try {
            $request->validate([
                'pembimbing_1' => 'required',
                'pembimbing_2' => 'required',
                'penguji_1' => 'required',
                'penguji_2' => 'required',
            ],[
                'pembimbing_1' => 'Kuota Pembimbing 1 wajib diisi',
                'pembimbing_2' => 'Kuota Pembimbing 2 wajib diisi',
                'penguji_1' => 'Kuota Penguji 1 wajib diisi',
                'penguji_2' => 'Kuota Penguji 2 wajib diisi',
            ]);
            if(session('switchRoles') == 'Kaprodi') {
                $user = getInfoLogin()->userable;
                $prodi = $user->programStudi;
                $request->merge([
                    'program_studi_id' => $prodi->id,
                ]);
            }

            if(session('switchRoles') == 'Admin') {
                $request->validate([
                    'program_studi_id' => 'required',
                ],[
                    'program_studi_id' => 'Program Studi wajib diisi',
                ]);
            }
            
            $periode = PeriodeTa::where('is_active', true)->where('program_studi_id', $request->program_studi_id)->first();
            $dosen = Dosen::all();
            foreach($dosen as $item) {
                $existingKuota = KuotaDosen::where('dosen_id', $item->id)->where('periode_ta_id', $periode->id)->where('program_studi_id', $request->program_studi_id)->exists();
                if ($existingKuota) {
                    return redirect()->back()->with('error', "Data sudah ada");
                } else {
                    KuotaDosen::create([
                        'dosen_id' => $item->id,
                        'periode_ta_id' => $periode->id,
                        'pembimbing_1' => $request->pembimbing_1,
                        'pembimbing_2' => $request->pembimbing_2,
                        'penguji_1' => $request->penguji_1,
                        'penguji_2' => $request->penguji_2,
                        'program_studi_id' => $request->program_studi_id
                    ]);
                }
            }
            return redirect()->back()->with('success', 'Berhasil menyimpan data');
        } catch (\Exception $e) {
            return redirect()->back()->with($e->getMessage());
        }
    }
}
