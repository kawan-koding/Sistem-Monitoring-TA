<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function bimbingUji()
    {
        return $this->belongsTo(BimbingUji::class);
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriNilai::class, 'kategori_nilai_id');
    }
}
