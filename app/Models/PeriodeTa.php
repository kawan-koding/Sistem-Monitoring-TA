<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodeTa extends Model
{
    use HasFactory;
    protected $table = 'periode_tas';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nama',
        'mulai_daftar',
        'akhir_daftar',
        'mulai_seminar',
        'akhir_seminar',
        'is_active',
    ];
}
