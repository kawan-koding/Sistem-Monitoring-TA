<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswas';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    public function tugas_akhir()
    {
        return $this->hasMany(TugasAkhir::class);
    }

    public function periodeTa()
    {
        return $this->belongsTo(PeriodeTa::class);
    }

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }
}
