<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;
    protected $table = 'dosens';

    protected $primaryKey = 'id';

    protected $guarded = [];

    public function rumpun_ilmu(){
        return $this->hasMany(RumpunIlmu::class);
    }

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }
}
