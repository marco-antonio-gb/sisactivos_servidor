<?php
/*
 * Copyright (c) 2021.  modem.ff@gmail.com | Marco Antonio Gutierrez Beltran
 */
namespace App\Models;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
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
	protected $table      = 'usuarios';
	protected $hidden     = array('pivot', 'password', 'remember_token');
	protected $casts      = ['estado' => 'boolean'];
	/**
	 * The accessors to append to the model's array form.
     *
	 * @var array
     */
	// notice that here the attribute name is in snake_case
	protected $appends    = ['avatar_letter', 'avatar_color', 'full_name'];
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
		'settings'
	];
	protected function serializeDate(DateTimeInterface $date) {
		return empty($date)
		? null
		: Carbon::parse($date)->translatedFormat('l, j \d\e F \d\e\l Y H:i:s');
	}
	public function getSettingsAttribute($value) {
		return json_decode($value);
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
	public function getFullNameAttribute() // notice that the attribute name is in CamelCase.
	{
		return $this->nombres . ' ' . $this->paterno . ' ' . $this->materno;
	}
}
