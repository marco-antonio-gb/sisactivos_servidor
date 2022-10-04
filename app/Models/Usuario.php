<?php
/*
 * Copyright (c) 2021.  modem.ff@gmail.com | Marco Antonio Gutierrez Beltran
 */
namespace App\Models;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @method static where(string $string, string $string1, $id)
 */
class Usuario extends Authenticatable implements JWTSubject {
	use HasFactory, Notifiable;
	use HasRoles;
	Protected $guard_name = 'api'; // added
	protected $primaryKey = 'idUsuario';
	protected $hidden     = array('pivot', 'password', 'remember_token');
	protected $appends    = ['user_name', 'avatar_letter', 'avatar_color'];
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
		return $date->format('Y-m-d H:i:s');
	}
	public function getUserNameAttribute() {
        $name  = $this->nombres!=null ? $this->nombres : "Sin nombre";

		return $name;
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
