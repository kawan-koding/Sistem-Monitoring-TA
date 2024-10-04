<?php

namespace App\Http\Controllers\Administrator\TopikTA;

use App\Models\Topik;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TopikTAController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Topik Tugas Akhir',
            'mods' => 'topik',
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
                    'title' => 'Topik Tugas Akhir',
                    'is_active' => true, 
                ]
            ],
            'dataTopik' => Topik::all(),
        ];

        return view('administrator.topik.index', $data);
    }

    public function store(Request $request)
    {
        try {
            $result = Topik::create([
                'nama_topik' => $request->nama_topik
            ]);
            return redirect()->route('apps.topik')->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->route('apps.topik')->with('error', $e->getMessage());
        }
    }

    public function show(string $id)
    {
        $topik = Topik::find($id);
        echo json_encode($topik);
    }

    public function update(Request $request)
    {
        try {
            $result = Topik::where('id', $request->id)->update([
                'nama_topik' => $request->nama_topik
            ]);
            return redirect()->route('apps.topik')->with('success', 'Data berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->route('apps.topik')->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try {
            Topik::where('id', $id)->delete();
        } catch (\Exception $e) {
            return redirect()->route('apps.topik')->with('error', $e->getMessage());
        }
    }
}
