<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;
    protected $table = 'nilais';
    protected $fillable = [
        'dosen_id', 'tugas_akhir_id', 'jenis', 'urut'
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }
    public function tugas_akhir()
    {
        return $this->belongsTo(TugasAkhir::class);
    }
}
