<?php

namespace App\Http\Controllers\Administrator\PeriodeTA;

use App\Models\PeriodeTa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PeriodeTA\PeriodeTARequest;

class PeriodeTAController extends Controller
{
    public function index()
    {
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
            'periode' => PeriodeTa::all()
        ];

        return view('administrator.periode-ta.index', $data);
    }

    public function store(PeriodeTARequest $request)
    {
        try {
            PeriodeTa::create($request->only('nama', 'mulai_daftar', 'akhir_daftar', 'mulai_seminar', 'akhir_seminar', 'mulai_sidang', 'akhir_sidang', 'mulai_pemberkasan', 'akhir_pemberkasan'));
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
            $periode->update($request->only('nama', 'mulai_daftar', 'akhir_daftar', 'mulai_seminar', 'akhir_seminar', 'mulai_sidang', 'akhir_sidang', 'mulai_pemberkasan', 'akhir_pemberkasan'));
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
                $activeCount = PeriodeTa::where('is_active', 1)->count();
                if ($activeCount <= 1) {
                    return $this->errorResponse(400, 'Setidaknya satu periode harus aktif!');
                }
            }

            if ($request->is == 1) {
                PeriodeTa::where('is_active', 1)->update(['is_active' => 0]);
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
