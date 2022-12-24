<?php

namespace App\Models;

use DateTimeInterface;

use Illuminate\Database\Eloquent\Model;

class OrgFinanciero extends Model
{
    protected $primaryKey = 'idOrgfinanciero';
	protected $casts      = ['condicion' => 'boolean'];
	protected $table      = 'org_financieros';

	protected $fillable   = [
		'nombre',
		'descripcion',
		'condicion'
	];
	protected function serializeDate(DateTimeInterface $date) {
		return $date->format('Y-m-d H:i:s');
	}
}
