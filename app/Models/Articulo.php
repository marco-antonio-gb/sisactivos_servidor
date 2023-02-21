<?php
namespace App\Models;
use DateTimeInterface;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Articulo extends Model {
	use SoftDeletes;
	protected $primaryKey = 'idArticulo';
	protected $table    = "articulos";
	protected $casts    = ['asignado' => 'boolean','baja' => 'boolean', 'idArticulo' => 'integer'];
	protected $fillable = [
		'codigo',
		'unidad',
		'nombre',
		'descripcion',
		'imagen',
		'costo',
		'estado',
		'asignado',
		'baja',
		'fecha_registro',
		'categoria_id',
		'orgfinanciero_id',
	];
	protected function serializeDate(DateTimeInterface $date) {
		return empty($date)
		? null
		: Carbon::parse($date)->translatedFormat('l, j \d\e F \d\e\l Y H:i:s');
	}
	public function getFechaRegistroAttribute($date) {
		return empty($date)
		? null
		: Carbon::parse($date)->translatedFormat('j \d\e F \d\e\l Y ');
	}
	public function orgfinanciero() {
		return $this->BelongsTo(OrgFinanciero::class, 'orgfinanciero_id', 'idOrgfinanciero');
	}
	public function categoria() {
		return $this->BelongsTo(Categoria::class, 'categoria_id', 'idCategoria');
	}
	public function archivo() {
		return $this->HasOne(Archivo::class, 'articulo_id', 'idArticulo');
	}
	public function detalle_baja(){
		return $this->HasOne(DetalleBaja::class, 'articulo_id','idArticulo');
	}
	public function detalle_asignacion(){
		return $this->HasOne(DetalleAsignacion::class, 'articulo_id','idArticulo')->with('asignacion');
	}
}
