<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $table = 'agenda';

    protected $fillable = [
        'Nombre', 'Comentario', 'fecha', 'idcaso'
    ];

    public function caso()
    {
        return $this->belongsTo(Caso::class, 'idcaso');
    }
}
