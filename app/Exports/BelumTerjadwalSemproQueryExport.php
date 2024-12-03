<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class BelumTerjadwalSemproQueryExport implements FromCollection
{
    protected $periodeId;
    protected $prodiId;
    protected $prodiName;
    protected $periodeName;
    protected $no = 1;
    
    public function __construct($periodeId, $prodiId, $prodiName, $periodeName)
    {
        $this->periodeId = $periodeId;
        $this->prodiId = $prodiId;
        $this->prodiName = $prodiName;
        $this->periodeName = $periodeName;
    }

    
    public function beforeSheet(BeforeSheet $event)
    {
        $this->no = 1;
    }

    public function collection()
    {
        //
    }
}
