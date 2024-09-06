<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisTa extends Model
{
    use HasFactory;
    protected $table = 'jenis_tas';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nama_jenis',
    ];
}
