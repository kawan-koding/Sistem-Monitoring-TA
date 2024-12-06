<?php

namespace App\Exports;

use App\Models\PeriodeTa;
use App\Models\TugasAkhir;
use App\Exports\TugasAkhirClass;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class TugasAkhirExport implements WithMultipleSheets
{
    protected $prodiId;
    protected $periode;

    public function __construct($prodiId)
    {
        $this->prodiId = $prodiId;
        $this->periode = PeriodeTa::where('program_studi_id', $this->prodiId)->where('is_active', true)->first();
        if (!$this->periode) {
            Redirect::back()->with('error', 'Tidak ada periode aktif di Prodi ini')->send();
        }
    }
    public function sheets(): array
    {
        $periode = PeriodeTa::whereIsActive(true)->whereProgramStudiId($this->prodiId)->first();
        $kelasGroups = TugasAkhir::where('periode_ta_id', $periode->id)->where('status', 'acc')->whereHas('mahasiswa', function ($query) {
            $query->where('program_studi_id', $this->prodiId);
        })->with('mahasiswa:id,kelas')->get()->pluck('mahasiswa.kelas')->unique()->values();
        $sheets = [];
        foreach ($kelasGroups as $kelas) {
            $sheets[] = new TugasAkhirClass($this->prodiId, $kelas, $periode->id);
        }
        return $sheets;
    }
}
