<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Password extends Model
{
    protected $table = 'usuarios';
    protected $primarykey = 'id';
    protected $fillable = ['usuario', 'name', 'apellido', 'email', 'password', 'cargo', 'rol'];
    use HasFactory;
}
