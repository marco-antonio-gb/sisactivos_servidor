<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class DetalleAsignacion extends Model {
	protected $primaryKey = 'idDetalleAsignacion';
	protected $table      = "asignaciones";
	protected $fillable   = [
		'detalle',
		'fecha_hora',
		'asignacion_id',
		'articulo_id',
	];
	protected function serializeDate(DateTimeInterface $date) {
		return $date->format('Y-m-d H:i:s');
	}
	public function asignacion() {
		return $this->BelongsTo(Asignacion::class, 'asignacion_id', 'idAsignacion');
	}

	public function articulo() {
		return $this->BelongsTo(Articulo::class, 'articulo_id', 'idArticulo');
	}
}
