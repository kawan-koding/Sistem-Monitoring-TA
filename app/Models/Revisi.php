<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revisi extends Model
{
    use HasFactory;
    protected $table = 'revisis';
    protected $fillable = ['dosen_id', 'tugas_akhir_id',];

    public function uraian_revisi(){
        return $this->hasMany(UraianRevisi::class);
    }

    public function dosen(){
        return $this->belongsTo(Dosen::class);
    }

    public function tugas_akhir(){
        return $this->belongsTo(TugasAkhir::class);
    }
}
