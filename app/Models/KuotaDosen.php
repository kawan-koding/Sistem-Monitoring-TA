<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuotaDosen extends Model
{
    use HasFactory;
    protected $table = 'kuota_dosens';

    protected $primaryKey = 'id';

    protected $guarded = [];
}
