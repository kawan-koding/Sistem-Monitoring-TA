<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodeTa extends Model
{
    use HasFactory;
    
    protected $table = 'periode_tas';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    public function tugasAkhir()
    {
        return $this->hasMany(TugasAkhir::class);
    }
}
