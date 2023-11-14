<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoID extends Model
{
    use HasFactory;
    protected $table = 'tipoids';
    public $timestamps = false; // Desactivar timestamps
}
