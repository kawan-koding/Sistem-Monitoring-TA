<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sidang extends Model
{
    use HasFactory;

    protected $guarded = [];

     public function tugas_akhir()
    {
        return $this->belongsTo(TugasAkhir::class);
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }

}

