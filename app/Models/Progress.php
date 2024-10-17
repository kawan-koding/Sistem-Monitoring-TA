<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tugasAkhir()
    {
        return $this->belongsTo(TugasAkhir::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

}
