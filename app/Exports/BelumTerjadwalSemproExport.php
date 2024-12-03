<?php

namespace App\Exports;

use App\Models\PeriodeTa;
use App\Exports\BelumTerjadwalSemproQueryExport;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class BelumTerjadwalSemproExport implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function sheets()
    {
        $sheets = [];
        $activePeriods = PeriodeTa::whereIsActive(true)->with('programStudi')->get();
        foreach ($activePeriods as $periode) {
            $sheets[] = new BelumTerjadwalSemproQueryExport(
                $periode->id,
                $periode->program_studi_id,
                $periode->programStudi->display,
                $periode->nama
            );
        }

        return $sheets;
    }
}
