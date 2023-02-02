<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

class Baja extends Model
{
    protected $primaryKey = 'idBaja';
	protected $table      = "bajas";
	protected $casts      = ['estado' => 'boolean'];

	protected $fillable   = [
		'estado',
		'responsable_id',
		'usuario_id',
	];
	protected function serializeDate(DateTimeInterface $date) {
		return empty($date)
		? null
		: Carbon::parse($date)->translatedFormat('l, j \d\e F \d\e\l Y H:i:s');
	}
	public function responsable() {
		return $this->BelongsTo(Responsable::class, 'responsable_id', 'idResponsable');
	}

	public function usuario() {
		return $this->BelongsTo(Usuario::class, 'usuario_id', 'idUsuario');
	}

    public function detalle_baja(){
        return $this->HasMany(DetalleBaja::class,'baja_id','idBaja')->with('articulo');
    }
}
