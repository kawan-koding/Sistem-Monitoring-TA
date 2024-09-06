<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;
    protected $table = 'mahasiswas';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'kelas',
        'nim',
        'nama_mhs',
        'jenis_kelamin',
        'email',
        'telp',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
    ];
}
