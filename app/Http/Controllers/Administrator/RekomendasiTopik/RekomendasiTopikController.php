<?php

namespace App\Http\Controllers\Administrator\RekomendasiTopik;

use App\Models\Dosen;
use App\Models\JenisTa;
use Illuminate\Http\Request;
use App\Models\RekomendasiTopik;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RekomendasiTopik\RekomendasiTopikRequest;

class RekomendasiTopikController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Rekomendasi Topik TA',
            'mods' => 'rekomendasi_topik',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Rekomendasi Topik',
                    'is_active' => true
                ]
            ],
            'data' => RekomendasiTopik::all(),
            'jenisTa' => JenisTa::all(),
        ];

        return view('administrator.rekomendasi-topik.index', $data);
    }

    public function store(RekomendasiTopikRequest $request)
    {
        try {
            $user = Auth::user();
            $dosen = Dosen::where('id', $user->userable_id)->first();
            $request->merge(['dosen_id' => $dosen->id]);                   
            RekomendasiTopik::create($request->only(['dosen_id','jenis_ta_id', 'judul', 'tipe', 'kuota']));
            return redirect()->route('apps.rekomendasi-topik')->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->route('apps.rekomendasi-topik')->with('error', $e->getMessage());
        }
    }
}
