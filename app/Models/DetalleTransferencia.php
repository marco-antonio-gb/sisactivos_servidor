<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

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
		return $date->format('Y-m-d H:i:s');
	}
	public function transferencias() {
		return $this->BelongsTo(Transferencia::class, 'transferencia_id', 'idTransferencia');
	}
	public function articulo() {
		return $this->BelongsTo(Articulo::class, 'articulo_id', 'idArticulo');
	}
}
