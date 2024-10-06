<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekomendasiTopik extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function jenisTa()
    {
        return $this->belongsTo(JenisTa::class);
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function ambilTawaran()
    {
        return $this->hasMany(AmbilTawaran::class);
    }
}
