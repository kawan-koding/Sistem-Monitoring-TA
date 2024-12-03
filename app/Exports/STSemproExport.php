<?php

namespace App\Exports;

use App\Models\PeriodeTa;
use App\Exports\STSemproQueryExport;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class STSemproExport implements WithMultipleSheets
{ 
    public function sheets(): array
    {
        $sheets = [];
        $activePeriods = PeriodeTa::where('is_active', true)->with('programStudi')->get();
        foreach ($activePeriods as $periode) {
            $sheets[] = new STSemproQueryExport(
                $periode->id,
                $periode->program_studi_id,
                $periode->programStudi->display,
                $periode->nama
            );
        }

        return $sheets;
    }
}
