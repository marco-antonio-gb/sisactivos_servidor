<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class DetalleTransferencia extends Model
{
    protected $primaryKey = 'idDetalleTransferencia';
	protected $table      = "detalle_transferencias";

	protected $fillable   = [
		'detalle',
		'fecha_hora',
		'transferencia_id',
		'articulo_id',
	];
	protected function serializeDate(DateTimeInterface $date) {
		return empty($date)
		? null
		: Carbon::parse($date)->translatedFormat('l, j \d\e F \d\e\l Y H:i:s');
	}
	public function transferencias() {
		return $this->BelongsTo(Transferencia::class, 'transferencia_id', 'idTransferencia');
	}
	public function articulo() {
		return $this->BelongsTo(Articulo::class, 'articulo_id', 'idArticulo');
	}
}
