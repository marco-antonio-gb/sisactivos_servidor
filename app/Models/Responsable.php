<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class Responsable extends Model
{
    protected $primaryKey = 'idResponsable';
    protected $table = "responsables";

    protected $fillable = [
        'servicio_id',
        'usuario_id',
        'condicion'
    ];

    protected function serializeDate(DateTimeInterface $date) {
		return $date->format('Y-m-d H:i:s');
	}
    public function usuario() {
		return $this->BelongsTo(Usuario::class, 'usuario_id', 'idUsuario');
	}
    public function servicio() {
		return $this->BelongsTo(Servicio::class, 'servicio_id', 'idServicio');
	}
}
