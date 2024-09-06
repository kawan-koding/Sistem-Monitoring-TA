<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topik extends Model
{
    use HasFactory;

    protected $table = 'topiks';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nama_topik',
    ];
}
