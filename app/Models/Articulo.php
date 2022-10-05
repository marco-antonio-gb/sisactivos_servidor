<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class Articulo extends Model {
	protected $primaryKey = 'idArticulo';
	protected $fillable   = [
		'codigo',
		'unidad',
		'nombre',
		'descripcion',
		'imagen',
		'costo',
		'estado',
		'condicion',
		'fecha_registro',
		'categoria_id',
		'orgfinanciero_id',
	];
	protected function serializeDate(DateTimeInterface $date) {
		return $date->format('Y-m-d H:i:s');
	}
}
