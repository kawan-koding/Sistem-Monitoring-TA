<?php

namespace App\Exports;

use App\Models\PeriodeTa;
use App\Exports\SKSidangAkhirQueryExport;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SKSidangAkhirExport implements WithMultipleSheets
{
    public function sheets(): array 
    {
        $sheets = [];
        $activePeriods = PeriodeTa::where('is_active', true)->with('programStudi')->get();
        foreach ($activePeriods as $periode) {
            $sheets[] = new SKSidangAkhirQueryExport(
                $periode->id,
                $periode->program_studi_id,
                $periode->programStudi->display,
                $periode->nama
            );
        }

        return $sheets;
    }

    
}
