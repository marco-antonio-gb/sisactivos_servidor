<?php

namespace App\Models;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model {
	protected $primaryKey = 'idCategoria';
	protected $casts      = ['condicion' => 'boolean'];
	protected $table      = 'categorias';

	protected $fillable = [
		'nombre',
		'vida_util',
		'descripcion',
		'condicion',
	];
	protected function serializeDate(DateTimeInterface $date) {
		return $date->format('Y-m-d H:i:s');
	}
}
