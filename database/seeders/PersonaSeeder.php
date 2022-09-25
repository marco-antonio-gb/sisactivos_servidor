<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Persona;

class PersonaSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		Persona::create([
			"paterno"=> "Veliz",
            "materno"=> "Perez",
            "nombres"=> "Israel",
            "ci"=> "5444217",
            "ci_ext"=> "OR",
            "foto" => "https://definicion.de/wp-content/uploads/2019/06/perfildeusuario.jpg",
            "celular"=> "7156824",
            "telefono" => "515147",
            "correo"=> "israel@gmail.com",
            "direccion"=> "Direccion del usuario",
            "cargo"     => "Ingeniero de Sistemas",
		]);
		 
	}
}
