<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailNilai extends Model
{
    use HasFactory;
    protected $table = 'detail_nilais';
    protected $fillable = [
        'nilai_id', 'aspek', 'angka', 'huruf'
    ];

    public function nilai()
    {
        return $this->belongsTo(Nilai::class);
    }
}
