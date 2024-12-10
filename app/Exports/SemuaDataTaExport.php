<?php

namespace App\Exports;

use App\Models\PeriodeTa;
use App\Models\TugasAkhir;
use App\Exports\SemuaDataTaQueryExport;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SemuaDataTaExport implements WithMultipleSheets
{
    protected $status;

    public function __construct($status)
    {
        $this->status = $status;
    }
    public function sheets(): array
    {
        $sheets = [];
        $activePeriods = PeriodeTa::whereIsActive(true)->with('programStudi')->get();
        foreach ($activePeriods as $periode) {
            $sheets[] = new SemuaDataTaQueryExport(
                $periode->id,
                $periode->program_studi_id,
                $periode->programStudi->display,
                $periode->nama,
                $this->status
            );
        }

        return $sheets;
    }
}
