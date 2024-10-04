<?php

namespace App\Http\Controllers\Administrator\Jurusan;

use App\Models\Jurusan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Jurusan\JurusanRequest;

class JurusanController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Jurusan',
            'mods' => 'jurusan',
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
                    'title' => 'Jurusan',
                    'is_active' => true
                ]
            ],
            'jurusan' => Jurusan::all(),
        ];

        return view('administrator.jurusan.index', $data);
    }

    public function store(JurusanRequest $request)
    {
        try {
            Jurusan::create($request->only(['kode', 'nama']));
    
            return redirect()->route('apps.jurusan')->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->route('apps.jurusan')->with('error', $e->getMessage());
        }
    }

    public function show(Jurusan $jurusan)
    {
        return response()->json($jurusan);
    }

    public function update(JurusanRequest $request, Jurusan $jurusan)
    {
        try {
            $jurusan->update($request->only(['kode', 'nama']));
            return redirect()->route('apps.jurusan')->with('success', 'Data berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->route('apps.jurusan')->with('error', $e->getMessage());
        }
    }

    public function destroy(Jurusan $jurusan)
    {
        try {
            $jurusan->delete();
            return $this->successResponse('Data berhasil di hapus');
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }
}
