<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccionesChile extends Model
{
    protected $table = 'acciones_chile';
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
    public function leadchile()
    {
        return $this->belongsTo(LeadsChile::class, 'lead', 'id');
    } 
}