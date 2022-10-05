<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
class Servicio extends Model
{
    protected $primaryKey = 'idServicio';
    protected $fillable = [
        'nombre',
        'codigo',
        'observacion',
        'condicion'
    ];
    protected function serializeDate(DateTimeInterface $date) {
		return $date->format('Y-m-d H:i:s');
	}

}
