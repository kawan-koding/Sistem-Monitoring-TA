<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;
    protected $table = 'dosens';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'nip',
        'nidn',
        'name',
        'jenis_kelamin',
        'email',
        'telp',
        'alamat',
        'ttd',
    ];

    public function rumpun_ilmu(){
        return $this->hasMany(RumpunIlmu::class);
    }
}
