<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historial extends Model
{
    use HasFactory;
    protected $table = 'historial';
    
    protected $fillable = [
        'persona_id', 'usuario_id', 'actividad_realizada', 'fecha_hora'
    ];
}
