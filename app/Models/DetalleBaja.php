<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class DetalleBaja extends Model
{
    protected $primaryKey = 'idDetalleBaja';
	protected $table      = "detalle_bajas";
	protected $fillable   = [
        'motivo',
        'informebaja',
        'fecha_hora',
        'baja_id',
        'articulo_id',
	];
	protected function serializeDate(DateTimeInterface $date) {
		return $date->format('Y-m-d H:i:s');
	}

	public function bajas() {
		return $this->BelongsTo(Baja::class, 'baja_id', 'idBaja');
	}

	public function articulos() {
		return $this->BelongsTo(Articulo::class, 'articulo_id', 'idArticulo');
	}
}
