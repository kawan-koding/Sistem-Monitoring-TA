<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BimbingUji extends Model
{
    use HasFactory;

    protected $table = 'bimbing_ujis';
    protected $fillable = [
        'tugas_akhir_id',
        'dosen_id',
        'jenis',
        'urut',
    ];

    public function tugas_akhir()
    {
        return $this->belongsTo(TugasAkhir::class);
    }
    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }
}
