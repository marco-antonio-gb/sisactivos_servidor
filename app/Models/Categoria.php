<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
	protected $primaryKey = 'idCategoria';
	protected $casts      = ['condicion' => 'boolean'];
	protected $table      = 'categorias';

	protected $fillable = [
		'nombre',
		'vida_util',
		'descripcion',
		'condicion',
	];
	protected function serializeDate(DateTimeInterface $date)
	{
		return empty($date)
			? null
			: Carbon::parse($date)->translatedFormat('l, j \d\e F \d\e\l Y H:i:s');
	}
	public function articulos()
	{
		return $this->hasMany(Articulo::class, 'categoria_id', 'idCategoria');
	}
}
