<?php
// app/Models/Lead.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'CAMPAIGN_NAME',
        'FORM_ID',
        'FORM_NAME',
        'IS_ORGANIC',
        'PLATFORM',
        'CONTANOS_MÁS_SOBRE_EL_PROYECTO',
        'FULL_NAME',
        'WORK_PHONE_NUMBER',
        'WORK_EMAIL',
        'JOB_TITLE',
        'NOMBRE_DE_LA_EMPRESA',
    ];
}

?>