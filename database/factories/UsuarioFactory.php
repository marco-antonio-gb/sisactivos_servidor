<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UsuarioFactory extends Factory {
	/**
	 * The name of the factory's corresponding model.
	 *
	 * @var string
	 */
	protected $model = Usuario::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition() {
		return [
			"paterno"   => $this->faker->lastName,
			"materno"   => $this->faker->lastName,
			"nombres"   => $this->faker->name,
			"ci"        => $this->faker->randomNumber(7),
			"ci_ext"    => $this->faker->randomElement(["OR", "LP", "PT", "CB", "CH", "TJ", "SC", "BN", "PD"]),
			"foto"      => NULL,
			"telefono"  => $this->faker->tollFreePhoneNumber,
			"correo"    => $this->faker->email,
			"direccion" => $this->faker->address,
			"cargo"     => $this->faker->jobTitle,
			"password"  => bcrypt('password'),
			"estado"    => true,
		];
	}
}
