<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GastoVariable extends Model
{
    use HasFactory;

    protected $table = 'gastos_variables';

    protected $fillable = ['monto', 'descripcion', 'proyecto_id', 'nombre'];

    // Definir relaciones Eloquent si es necesario
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');

    }
}