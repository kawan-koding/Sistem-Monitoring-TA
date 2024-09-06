<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RumpunIlmu extends Model
{
    use HasFactory;
    protected $table = 'rumpun_ilmus';
    protected $primaryKey = 'id';
    protected $fillable = ['nama','dosen_id'];

    public function dosen(){
        return $this->belongsTo(Dosen::class);
    }
}
