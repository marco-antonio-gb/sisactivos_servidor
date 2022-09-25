<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class persona extends Model
{
    use HasFactory;
     
    protected $primaryKey = 'idPersona';
    protected $fillable = [
        'paterno',
        'materno',
        'nombres',
        'ci',
        'ci_ext',
        'direccion',
        'celular',
        'telefono',
        'cargo',
        'foto',
        'correo'
    ];
 
    
}
