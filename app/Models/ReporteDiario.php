<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReporteDiario extends Model
{
    use HasFactory;
    protected $table = 'reportes_diarios'; // Nombre de la tabla en la base de datos

    protected $fillable = [
        'iduser', 'idcaso', 'descripcion', 'fecha','hora','estado','enviado','pais','created_at','updated_at'
    ];
    // Si no deseas usar las marcas de tiempo created_at y updated_at
    public $timestamps = false;
}
