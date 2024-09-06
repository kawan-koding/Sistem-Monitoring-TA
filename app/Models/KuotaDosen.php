<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuotaDosen extends Model
{
    use HasFactory;
    protected $table = 'kuota_dosens';

    protected $primaryKey = 'id';

    protected $fillable = [
        'dosen_id',
        'periode_ta_id',
        'pemb_1',
        'pemb_2',
        'penguji_1',
        'penguji_2',
    ];
}
