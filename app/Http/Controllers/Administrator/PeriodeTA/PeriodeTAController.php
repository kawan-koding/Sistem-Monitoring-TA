<?php

namespace App\Http\Controllers\Administrator\PeriodeTA;

use App\Models\PeriodeTa;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PeriodeTA\PeriodeTARequest;

class PeriodeTAController extends Controller
{
    public function index()
    {
        $periode = PeriodeTa::with(['programStudi']);
        if(session('switchRoles') == 'Kaprodi') {
            $periode->where('program_studi_id', getInfoLogin()->userable->programStudi->id);
        }
        $periode = $periode->get();

        $data = [
            'title' => 'Periode TA',
            'mods' => 'periode_ta',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Periode TA',
                    'is_active' => true
                ]
            ],
            'prodi' => ProgramStudi::all(),
            'periode' => $periode,
        ];
        return view('administrator.periode-ta.index', $data);
    }

    public function store(PeriodeTARequest $request)
    {
        try {
            if(session('switchRoles') == 'Kaprodi') {
                $request->merge(['program_studi_id' => getInfoLogin()->userable->programStudi->id]);
                PeriodeTa::create($request->only('nama', 'mulai_daftar', 'akhir_daftar', 'mulai_seminar', 'akhir_seminar', 'mulai_sidang', 'akhir_sidang', 'program_studi_id'));
            }
            
            if(session('switchRoles') == 'Admin') {
                $prodi = $request->input('program_studi_id', []);
                if (empty($prodi) || !is_array($prodi)) {
                    return redirect()->back()->with('error', 'Program studi harus dipilih.');
                }
                
                foreach ($prodi as $id) {
                    if (!ProgramStudi::where('id', $id)->exists()) {
                        return redirect()->back()->with('error', 'Program studi dengan ID ' . $id . ' tidak valid.');
                    }

                    $exists = PeriodeTa::where('nama', $request->nama)->where('program_studi_id', $id)->exists();
                    if($exists) {
                        return redirect()->back()->with('error', 'Periode TA  sudah ada');
                    } else {
                        $request->merge(['program_studi_id' => $id]);
                        PeriodeTa::create($request->only('nama', 'mulai_daftar', 'akhir_daftar', 'mulai_seminar', 'akhir_seminar', 'mulai_sidang', 'akhir_sidang', 'program_studi_id'));
                    }
                }
            }
            return redirect()->route('apps.periode')->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show(PeriodeTa $periode)
    {
        return response()->json($periode);
    }

    public function update(PeriodeTARequest $request, PeriodeTa $periode)
    {
        try {
            $existingPeriode = PeriodeTa::where('nama', $request->nama)->where('program_studi_id', $request->program_studi_id)->exists();
            if ($existingPeriode) {
                return redirect()->back()->with('error', 'Periode TA sudah ada!');
            }
            $periode->update($request->only('nama', 'mulai_daftar', 'akhir_daftar', 'mulai_seminar', 'akhir_seminar', 'mulai_sidang', 'akhir_sidang'));
            return redirect()->route('apps.periode')->with('success', 'Data berhasil diubah');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(PeriodeTa $periode)
    {
        try {
            if($periode->is_active == 1) {
                return $this->errorResponse(400, 'Periode TA aktif tidak bisa di hapus');
            }
            $periode->delete();
            return $this->successResponse('Data berhasil di hapus');
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function change(PeriodeTa $periode, Request $request)
    {
        try {
            if ($request->is == 0) {
                $activeCount = PeriodeTa::where('program_studi_id', $periode->program_studi_id)->where('is_active', 1)->count();
    
                if ($activeCount <= 1) {
                    return $this->errorResponse(400, 'Setidaknya satu periode harus aktif untuk setiap program studi!');
                }
            }
    
            if ($request->is == 1) {
                PeriodeTa::where('program_studi_id', $periode->program_studi_id)->where('is_active', 1)->update(['is_active' => 0]);
            }
    
            $periode->update([
                'is_active' => $request->is
            ]);
    
            return $this->successResponse('Data berhasil diubah');
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }
    
}
