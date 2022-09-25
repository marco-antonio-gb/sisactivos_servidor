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
	protected $hidden     = array('pivot', 'password', 'remember_token', 'permissions');
	protected $casts      = [
		'condicion' => 'boolean',
	];
	protected $fillable = [
		'username',
		'password',
		'persona_id',
		'condicion',
	];
	public function persona() {
		return $this->belongsTo(Persona::class, 'persona_id', 'idPersona');
	}
	protected function serializeDate(DateTimeInterface $date) {
		return $date->format('Y-m-d H:i:s');
	}
	public function getCreatedAtEsAttribute() {
		return Carbon::parse($this->created_at)->translatedFormat('l, j \d\e F \d\e\l Y');
	}
	public function getUpdatedAtEsAttribute() {
		return Carbon::parse($this->updated_at)->translatedFormat('l, j \d\e F \d\e\l Y');
	}
	/**
	 * Get the identifier that will be stored in the subject claim of the JWT.
	 *
	 * @return mixed
	 */
	public function getJWTIdentifier() {
		return $this->getKey();
	}
	/**
	 * Return a key value array, containing any custom claims to be added to the JWT.
	 *
	 * @return array
	 */
	public function getJWTCustomClaims() {
		return [];
	}
}
