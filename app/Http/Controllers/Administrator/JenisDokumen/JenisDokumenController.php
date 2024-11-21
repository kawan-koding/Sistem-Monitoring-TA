<?php

namespace App\Http\Controllers\Administrator\JenisDokumen;

use App\Models\JenisDokumen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\JenisDokumen\JenisDokumenRequest;

class JenisDokumenController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Jenis Dokumen',
            'mods' => 'jenis_dokumen',
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
                    'title' => 'Jenis Dokumen',
                    'is_active' => true
                ]
            ],
            'data' => JenisDokumen::all(),
        ];

        return view('administrator.jenis-dokumen.index', $data);
    }


    public function store(JenisDokumenRequest $request)
    {
        try {
            JenisDokumen::create($request->only(['nama', 'jenis', 'tipe_dokumen', 'max_ukuran']));
            return redirect()->route('apps.jenis-dokumen')->with('success', 'Data berhasil ditambahkan');
        } catch(Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show(JenisDokumen $jenisDokumen)
    {
        return response()->json($jenisDokumen);
    }
    
    public function update(JenisDokumenRequest $request, JenisDokumen $jenisDokumen)
    {
        try {
            $jenisDokumen->update($request->only(['nama', 'jenis', 'tipe_dokumen', 'max_ukuran']));
            return redirect()->route('apps.jenis-dokumen')->with('success', 'Data berhasil diperbarui');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(JenisDokumen $jenisDokumen)
    {
        try {
            $jenisDokumen->delete();
            return $this->successResponse('Data berhasil dihapus');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
