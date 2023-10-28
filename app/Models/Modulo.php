<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    protected $table = 'proyectos'; // Reemplaza 'proyectos' por el nombre real de la tabla

    protected $fillable = [
        // Lista de columnas que se pueden asignar masivamente
        'id_Proyecto',
        'nombre_modulo',
        'descripcion_modulo',
        'cantidad_procesos',
        // Agrega aquí otras columnas que puedas tener en la tabla modulos...
    ];
    public $timestamps = false; // Desactivar timestamps automáticos
    public function proyectos()
    {
        return $this->belongsTo(FormData::class, 'id_Proyecto', 'id_Proyecto');
    }

    public function procesos()
    {
        
    }
}
