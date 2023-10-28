<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;

class Roles extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $fillable = ['nombre', 'descripcion', 'usuarios', 'roles','leads'];
    protected $boolean = [
        'usuarios' => 'boolean',
        'roles' => 'boolean',
        'leads' => 'boolean',
    ];
    use HasFactory;
    public function Usuarios()
    {
        return $this->hasMany(Usuarios::class, 'rol', 'id');
    }
}