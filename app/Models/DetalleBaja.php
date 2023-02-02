<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
use Illuminate\Support\Carbon;

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
		return empty($date)
		? null
		: Carbon::parse($date)->translatedFormat('l, j \d\e F \d\e\l Y H:i:s');
	}

	public function bajas() {
		return $this->BelongsTo(Baja::class, 'baja_id', 'idBaja');
	}

	public function articulo() {
		return $this->BelongsTo(Articulo::class, 'articulo_id', 'idArticulo');
	}
}
