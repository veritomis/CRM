<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadsArgentina extends Model
{
    protected $table = 'leads_argentina';
    protected $primarykey = 'id';
    protected $fillable = [
        'campaign_name',
        'form_id',
        'form_name',
        'is_organic',
        'platform',
        'cuentanos_mas_sobre_el_proyecto',
        'full_name',
        'work_phone_number',
        'work_email',
        'nombre_de_la_empresa',
        'job_title',
        'cotizacion',
        'tipificacion',
        'created at'
    ];
    protected $boolean = [
        'cotizacion' => 'boolean',
    ];
    use HasFactory;
    public function accionesargentina()
{
    return $this->hasMany(AccionesArgentina::class, 'lead', 'id');
}
}
