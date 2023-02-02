<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Support\Carbon;

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
		return empty($date)
		? null
		: Carbon::parse($date)->translatedFormat('l, j \d\e F \d\e\l Y H:i:s');
	}
}
