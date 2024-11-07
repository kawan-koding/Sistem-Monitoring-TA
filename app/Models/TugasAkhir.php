<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasAkhir extends Model
{
    use HasFactory;

    protected $table = 'tugas_akhirs';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function mahasiswa(){
        return $this->belongsTo(Mahasiswa::class);
    }
    public function jenis_ta(){
        return $this->belongsTo(JenisTa::class);
    }
    public function topik(){
        return $this->belongsTo(Topik::class);
    }
    public function periode_ta(){
        return $this->belongsTo(PeriodeTa::class);
    }
    public function bimbing_uji(){
        return $this->hasMany(BimbingUji::class);
    }
    public function jadwal_seminar(){
        return $this->hasOne(JadwalSeminar::class);
    }
}
