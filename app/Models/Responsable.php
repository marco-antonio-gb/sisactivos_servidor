<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Responsable extends Model {
	protected $primaryKey = 'idResponsable';
	protected $table      = "responsables";
	protected $casts      = ['condicion' => 'boolean'];
	protected $fillable   = [
		'servicio_id',
		'usuario_id',
		'condicion',
	];

	protected function serializeDate(DateTimeInterface $date) {
		return empty($date)
		? null
		: Carbon::parse($date)->translatedFormat('l, j \d\e F \d\e\l Y H:i:s');
	}	
	public function usuario() {
		return $this->BelongsTo(Usuario::class, 'usuario_id', 'idUsuario');
	}
	public function servicio() {
		return $this->BelongsTo(Servicio::class, 'servicio_id', 'idServicio');
	}
	public function asignaciones() {
		return $this->HasMany(Asignacion::class, 'responsable_id', 'idResponsable')->with('usuario')->with('detalle_asignacion');
	}
}
