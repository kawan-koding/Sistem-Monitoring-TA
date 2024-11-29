<?php

namespace App\Exports;

use App\Models\PeriodeTa;
use App\Models\TugasAkhir;
use App\Exports\TugasAkhirClass;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class TugasAkhirExport implements WithMultipleSheets
{
    protected $prodiId;

    public function __construct($prodiId)
    {
        $this->prodiId = $prodiId;
    }
    public function sheets(): array
    {
        $periode = PeriodeTa::whereIsActive(true)->first();
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
