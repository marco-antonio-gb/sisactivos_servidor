<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

class DetalleAsignacion extends Model {
	protected $primaryKey = 'idDetalleAsignacion';
	protected $table      = "detalle_asignaciones";
	protected $fillable   = [
		'detalle',
		'fecha_hora',
		'asignacion_id',
		'articulo_id',
	];
	protected function serializeDate(DateTimeInterface $date) {
		return empty($date)
		? null
		: Carbon::parse($date)->translatedFormat('l, j \d\e F \d\e\l Y H:i:s');
	}
	public function getFechaHoraAttribute($value) {
		return empty($value)
		? null
		: Carbon::parse($value)->translatedFormat('l, j \d\e F \d\e\l Y H:i:s');
	}
	public function asignacion() {
		return $this->BelongsTo(Asignacion::class, 'asignacion_id', 'idAsignacion')->with('responsable');
	}

	public function articulo() {
		return $this->BelongsTo(Articulo::class, 'articulo_id', 'idArticulo')->with('orgfinanciero')->with('categoria')->with('detalle_baja');
	}
}
