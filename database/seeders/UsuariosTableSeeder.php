<?php
namespace Database\Seeders;
use App\Models\Usuario;
use Illuminate\Database\Seeder;
class UsuariosTableSeeder extends Seeder {
	public function run() {
		Usuario::create([
            "paterno"=> "Veliz",
            "materno"=> "Perez",
            "nombres"=> "Israel",
            "ci"=> "5444217",
            "ci_ext"=> "OR",
            "foto" => "https://definicion.de/wp-content/uploads/2019/06/perfildeusuario.jpg",
            
            "telefono" => "515147",
            "correo"=> "israel@gmail.com",
            "direccion"=> "Direccion del usuario",
            "cargo"     => "Ingeniero de Sistemas",
			"username"         => "israel@gmail.com",
			"password"      => bcrypt('israel@gmail.com'),
			"estado"        => true,
			 
		]);
	}
}
