<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmbilTawaran extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function rekomendasiTopik()
    {
        return $this->belongsTo(RekomendasiTopik::class);
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
