<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccionesArgentina extends Model
{
    protected $table = 'acciones_argentina';
    protected $primarykey = 'id';
    protected $fillable = [
        'accion',
        'comentario',
        'documento1',
        'documento2',
        'usuario',
        'lead',
    ];
    use HasFactory;
    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'usuario');
    }
    public function leadargentina()
    {
        return $this->belongsTo(LeadsArgentina::class, 'lead', 'id');
    } 
}
