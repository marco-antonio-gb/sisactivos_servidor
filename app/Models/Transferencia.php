<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class Transferencia extends Model
{
    protected $primaryKey = 'idTransferencia';
	protected $table      = "transferencias";
	protected $casts      = ['estado' => 'boolean'];

	protected $fillable   = [
		'fecha_hora',
		'estado',
		'responsable_id',
	];
	protected function serializeDate(DateTimeInterface $date) {
		return $date->format('Y-m-d H:i:s');
	}
	public function responsable() {
		return $this->BelongsTo(Responsable::class, 'responsable_id', 'idResponsable');
	}
}
