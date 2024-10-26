<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriNilai extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class);
    }
}

