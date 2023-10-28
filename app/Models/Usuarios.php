<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    protected $table = 'usuarios';
    protected $primarykey = 'id';
    protected $fillable = ['usuario','name','apellido','email','password','cargo','rol','activo','cotizador','last_activity'];
    use HasFactory;
    public function rol()
{
    return $this->belongsTo(Roles::class, 'rol');
}
}
