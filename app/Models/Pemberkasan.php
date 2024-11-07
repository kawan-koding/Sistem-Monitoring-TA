<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemberkasan extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function jenisDokumen()
    {
        return $this->belongsTo(JenisDokumen::class);
    }
}

