<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormDataCle extends Model
{
    protected $table = 'proyectos_Chile'; // Reemplaza 'proyectos' por el nombre real de la tabla

    protected $fillable = ['id',
        'idconsulta',
        'condiciones',
        'T_implementaciOn',
        'Testing',
        'Costo_Total',
        'nombre_proyecto',
        'descripcion_proyecto',
        'cantidad_modulos',
        'nombre_modulo',
        'descripcion_modulo',

        'cantidad_procesos_1',
        'nombre_proceso_1',
        'descripcion_proceso_1',
        'nombre_proceso_2',
        'descripcion_proceso_2',
        'nombre_proceso_3',
        'descripcion_proceso_3',
        'nombre_proceso_4',
        'descripcion_proceso_4',
        'nombre_proceso_5',
        'descripcion_proceso_5',
        'nombre_proceso_6',
        'descripcion_proceso_6',
        'nombre_proceso_7',
        'descripcion_proceso_7',
        'nombre_proceso_8',
        'descripcion_proceso_8',
        'nombre_proceso_9',
        'descripcion_proceso_9',
        'nombre_proceso_10',
        'descripcion_proceso_10',
        // Agrega aquí otras columnas que puedas tener en la tabla proyectos...
    ];
    public function modulos()
    {
        return $this->hasMany(Modulo::class, 'id_Proyecto', 'id_Proyecto');
    }
    // Resto del código del modelo...
}
