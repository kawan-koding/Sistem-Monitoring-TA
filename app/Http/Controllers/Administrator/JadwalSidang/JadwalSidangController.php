<?php

namespace App\Http\Controllers\Administrator\JadwalSidang;

use App\Models\Sidang;
use App\Models\Mahasiswa;
use App\Models\PeriodeTa;
use App\Models\JenisDokumen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JadwalSidangController extends Controller
{
    public function index(Request $request)
    {
        $query = [];
        $periode = PeriodeTa::where('is_active', 1)->first();
        $query = Sidang::with(['tugas_akhir']);
        if(getInfoLogin()->hasRole('Mahasiswa')) {
            $myId = getInfoLogin()->userable;
            $mahasiswa = Mahasiswa::where('id', $myId->id)->first();
            if($mahasiswa) {
                $query->whereHas('tugas_akhir', function ($q) use($periode, $mahasiswa) {
                    $q->where('periode_ta_id', $periode->id)->where('mahasiswa_id', $mahasiswa->id);
                });
                $query = $query->get();
            }
        }

        if(getInfoLogin()->hasRole('Admin')) {
            if($request->has('tanggal') && !empty($request->tanggal)) {
                $query = $query->whereDate('tanggal', $request->tanggal);
            }

            if($request->has('status') && !empty($request->status)) {
                $query = $query->where('status', $request->status);
            } else {
                $query = $query->where('status', 'belum_terjadwal');
            }
            $query = $query->get();

            $query = $query->map(function($item) {
                $jenisDocument = JenisDokumen::whereIn('jenis', ['sidang', 'pra_sidang'])->count();
                $jenisDocumentComplete = JenisDokumen::whereIn('jenis', ['sidang', 'pra_sidang'])->whereHas('pemberkasan', function($q) use ($item) {
                    $q->where('tugas_akhir_id', $item->tugas_akhir->id);
                })->count();
                $item->document_complete = $jenisDocument - $jenisDocumentComplete == 0;
                return $item;
            });
        }

        // dd($query);
        $docSidang = JenisDokumen::whereIn('jenis', ['sidang', 'pra_sidang'])->get();
        $data = [
            'title' =>  'Jadwal Sidang',
            'mods' => 'jadwal_sidang',
            'breadcrumbs' =>[
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Jadwal Sidang',
                    'is_active' => true,
                ]
            ],
            'data' => $query,
            'status' => $request->has('status') ? $request->status : null,
            'document_sidang' => $docSidang,
        ];
        
        return view('administrator.jadwal-sidang.index', $data);
    }
}
