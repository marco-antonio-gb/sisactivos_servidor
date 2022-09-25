<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;

class UsuariosTableSeeder extends Seeder {

	public function run() {
		Usuario::create([
			"username"         => "israel@gmail.com",
			"password"      => bcrypt('israel@gmail.com'),
		 
			"condicion"        => true,
			"persona_id"    => 1
		]);
 
	}
}
