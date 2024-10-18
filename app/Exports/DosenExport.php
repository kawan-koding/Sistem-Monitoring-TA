<?php

namespace App\Exports;

use App\Models\Dosen;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DosenExport implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
       public function sheets(): array 
    {
        $sheets = [];
        $sheets[] = new HeadingDosen();
        $sheets[] = new ProgramStudiExport();
        return $sheets;
    }
}
