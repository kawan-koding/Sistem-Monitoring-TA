<?php

namespace App\Exports;

use App\Exports\PeriodeExport;
use App\Exports\HeadingMahasiswa;
use App\Exports\ProgramStudiExport;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MahasiswaExport implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function sheets(): array 
    {
        $sheets = [];
        $sheets[] = new HeadingMahasiswa();
        $sheets[] = new ProgramStudiExport();
        $sheets[] = new PeriodeExport();
        return $sheets;
    }
    
}
