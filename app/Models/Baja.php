<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class Baja extends Model
{
    protected $primaryKey = 'idBaja';
	protected $table      = "bajas";
	protected $casts      = ['estado' => 'boolean'];

	protected $fillable   = [
		'estado',
		'responsable_id',
		'usuario_id',
	];
	protected function serializeDate(DateTimeInterface $date) {
		return $date->format('Y-m-d H:i:s');
	}
	public function responsable() {
		return $this->BelongsTo(Responsable::class, 'responsable_id', 'idResponsable');
	}

	public function usuario() {
		return $this->BelongsTo(Usuario::class, 'usuario_id', 'idUsuario');
	}
}
