<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;


class Asignacion extends Model
{
	protected $primaryKey = 'idAsignacion';
	protected $table      = "asignaciones";
	protected $casts      = ['estado' => 'boolean'];
	protected $fillable   = [
		'responsable_id',
		'usuario_id',
		'estado',
	];

	protected function serializeDate(DateTimeInterface $date)
	{
		return empty($date)
			? null
			: Carbon::parse($date)->translatedFormat('l, j \d\e F \d\e\l Y H:i:s');
	}

	public function responsable()
	{
		return $this->BelongsTo(Responsable::class, 'responsable_id', 'idResponsable')->with('usuario')->with('servicio');
	}

	public function usuario()
	{
		return $this->BelongsTo(Usuario::class, 'usuario_id', 'idUsuario');
	}

	public function detalle_asignacion()
	{
		return $this->HasMany(DetalleAsignacion::class, 'asignacion_id', 'idAsignacion')->with('articulo');
	}
}
