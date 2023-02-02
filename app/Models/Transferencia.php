<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Support\Carbon;

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
        'usuario_id'
	];
	protected function serializeDate(DateTimeInterface $date) {
		return empty($date)
		? null
		: Carbon::parse($date)->translatedFormat('l, j \d\e F \d\e\l Y H:i:s');
	}
	public function responsable() {
		return $this->BelongsTo(Responsable::class, 'responsable_id', 'idResponsable')->with('usuario');
	}
	public function usuario() {
		return $this->BelongsTo(Usuario::class, 'usuario_id', 'idUsuario');
	}
    public function detalle_transferencia() {
		return $this->HasMany(DetalleTransferencia::class, 'transferencia_id', 'idTransferencia')->with('articulo');
	}
}
