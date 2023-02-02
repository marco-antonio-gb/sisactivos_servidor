<?php
/*
 * Copyright (c) 2021.  modem.ff@gmail.com | Marco Antonio Gutierrez Beltran
 */
namespace App\Models;
use DateTimeInterface;
use Illuminate\Support\Carbon;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @method static where(string $string, string $string1, $id)
 */
class Usuario extends Authenticatable implements JWTSubject {
	use HasFactory, Notifiable;
	use HasRoles;
	Protected $guard_name = 'api'; // added
	protected $primaryKey = 'idUsuario';
    protected $table = 'usuarios';
	protected $hidden     = array('pivot', 'password', 'remember_token');
	protected $appends    = [  'avatar_letter', 'avatar_color'];
	protected $casts      = ['estado' => 'boolean'];
	protected $fillable   = [
		'paterno',
		'materno',
		'nombres',
		'ci',
		'ci_ext',
		'direccion',
		'telefono',
		'cargo',
		'foto',
		'correo',
		'username',
		'password',
		'estado',
	];
	protected function serializeDate(DateTimeInterface $date) {
		return empty($date)
		? null
		: Carbon::parse($date)->translatedFormat('l, j \d\e F \d\e\l Y H:i:s');
	}

	public function getAvatarLetterAttribute() {
		return SKU_gen($this->nombres);
	}
	public function getAvatarColorAttribute() {
		return getcolorAvatar($this->nombres);
	}
	public function getJWTIdentifier() {
		return $this->getKey();
	}
	public function getJWTCustomClaims() {
		return [];
	}
}
