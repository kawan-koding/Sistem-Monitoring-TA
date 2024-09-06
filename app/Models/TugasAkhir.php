<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasAkhir extends Model
{
    use HasFactory;

    protected $table = 'tugas_akhirs';

    protected $primaryKey = 'id';

    protected $fillable = [
        'jenis_ta_id',
        'topik_id',
        'mahasiswa_id',
        'periode_ta_id',
        'judul',
        'tipe',
        'dokumen_pemb_1',
        'dokumen_ringkasan',
        'file_proposal',
        'file_pengesahan',
        'file_draft',
        'status',
        'catatan',
        'status_seminar',
        'periode_mulai',
        'periode_akhir',
    ];

    public function mahasiswa(){
        return $this->belongsTo(Mahasiswa::class);
    }
    public function jenis_ta(){
        return $this->belongsTo(JenisTa::class);
    }
    public function topik(){
        return $this->belongsTo(Topik::class);
    }
    public function periode_ta(){
        return $this->belongsTo(PeriodeTa::class);
    }
    public function bimbing_uji(){
        return $this->hasMany(BimbingUji::class);
    }
}
