<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model {
    protected $table='funcionarios';
	protected $primaryKey = 'idFuncionario';
	protected $fillable   = [
		'apellidos',
		'nombre',
		'ci',
	];
}
