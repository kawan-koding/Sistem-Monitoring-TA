<?php

namespace App\Http\Controllers\Administrator\ProgramStudi;

use App\Models\Jurusan;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProgramStudi\ProgramStudiRequest;

class ProgramStudiController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Program Studi',
            'mods' => 'program_studi',
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
                    'title' => 'Program Studi',
                    'is_active' => true
                ]
            ],
            'programStudi' => ProgramStudi::all(),
            'jurusan' => Jurusan::all(),
        ];

        return view('administrator.program-studi.index', $data);
    }

    public function store(ProgramStudiRequest $request)
    {
        try {
            ProgramStudi::create($request->only(['kode', 'nama', 'jurusan_id']));
    
            return redirect()->route('apps.program-studi')->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->route('apps.program-studi')->with('error', $e->getMessage());
        }
    }


    public function show(ProgramStudi $programStudi)
    {
        return response()->json($programStudi);
    }

    public function update(ProgramStudiRequest $request, ProgramStudi $programStudi)
    {
        try {
            $programStudi->update($request->only(['kode', 'nama', 'jurusan_id']));
            return redirect()->route('apps.program-studi')->with('success', 'Data berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->route('apps.program-studi')->with('error', $e->getMessage());
        }
    }

    public function destroy(ProgramStudi $programStudi)
    {
        try {
            $programStudi->delete();
    
            return $this->successResponse('Data berhasil di hapus');
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }
}
