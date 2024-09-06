<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalSeminar extends Model
{
    use HasFactory;
    protected $table = 'jadwal_seminars';
    protected $fillable = [
        'tugas_akhir_id',
        'ruangan_id',
        'hari_id',
        'jam_mulai',
        'jam_selesai',
        'tanggal',
        'status',
    ];

    public function tugas_akhir(){
        return $this->belongsTo(TugasAkhir::class);
    }
    public function ruangan(){
        return $this->belongsTo(Ruangan::class);
    }
    public function hari(){
        return $this->belongsTo(Hari::class);
    }
}

