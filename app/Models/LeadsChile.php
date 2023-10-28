<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadsChile extends Model
{
    protected $table = 'leads_chile';
    protected $primarykey = 'id';
    protected $fillable = [
        'campaign_name',
        'form_id',
        'form_name',
        'is_organic',
        'platform',
        'cuentanos_sobre_el_proyecto',
        'full_name',
        'phone_number',
        'email',
        'company_name',
        'job_title',
        'cotizacion',
        'tipificacion',
        'created at'
    ];
    protected $boolean = [
        'cotizacion' => 'boolean',
    ];
    use HasFactory;
    public function accioneschile()
{
    return $this->hasMany(AccionesChile::class, 'lead', 'id');
}
}
