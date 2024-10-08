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
    
    public function store(Request $request)
    {
        try {
            $data = KuotaDosen::where('dosen_id', $request->dosen_id)->where('periode_ta_id', $request->periode_ta_id)->first();
            if(isset($data->id)){
                $data->update([
                    $request->field => $request->value,
                ]);
            } else {
                KuotaDosen::create([
                    'dosen_id' => $request->dosen_id,
                    'periode_ta_id' => $request->periode_ta_id,
                    $request->field => $request->value,
                ]);
            }
            return $this->successResponse('Data berhasil disimpan');
        } catch(Exception $e) {
            return $this->exceptionResponse($e);
        }
    }
}
