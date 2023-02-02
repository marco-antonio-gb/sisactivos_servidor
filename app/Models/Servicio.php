<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

use DateTimeInterface;
class Servicio extends Model
{
    protected $primaryKey = 'idServicio';
    protected $table = "servicios";
    protected $casts      = ['condicion' => 'boolean'];
    protected $fillable = [
        'nombre',
        'codigo',
        'observacion',
        'condicion'
    ];
    protected function serializeDate(DateTimeInterface $date) {
		return empty($date)
		? null
		: Carbon::parse($date)->translatedFormat('l, j \d\e F \d\e\l Y H:i:s');
	}

}
