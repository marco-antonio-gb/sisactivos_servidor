<?php
namespace Database\Seeders;
use App\Models\Usuario;
use Illuminate\Database\Seeder;
class UsuariosTableSeeder extends Seeder {
	public function run() {
		Usuario::create([
			"paterno"   => "Veliz",
			"materno"   => "Herrera",
			"nombres"   => "Israel Zenon",
			"ci"        => "5444217",
			"ci_ext"    => "OR",
			"foto"      => "a569fdc3-c91a-47c5-9e09-fa837e4533ce.jpg",
			"telefono"  => "515147",
			"correo"    => "israel@gmail.com",
			"direccion" => "Direccion del usuario",
			"cargo"     => "Ingeniero de Sistemas",
			"password"  => bcrypt('israel@gmail.com'),
			"estado"    => true,
			"settings"  => '{"dark_theme": false}',

		]);
        // Usuario::factory()->count(6)->create();

	}
}
