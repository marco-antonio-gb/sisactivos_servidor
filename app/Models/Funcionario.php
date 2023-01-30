<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model {
    protected $table='funcionarios';
	protected $primaryKey = 'idFuncionario';
	protected $casts      = ['estado' => 'boolean'];

	protected $fillable   = [
		'apellidos',
		'nombres',
		'ci',
		'ci_ext',
		'cargo',
		'documento',
		'estado',
	];
}
