<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UraianRevisi extends Model
{
    use HasFactory;
    protected $table = 'uraian_revisis';
    protected $fillable = [
        'revisi_id', 'uraian', 'status'
    ];

    public function revisi(){
        return $this->belongsTo(Revisi::class);
    }
}
