<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		Role::create([
			'name'       => "Administrador",
			'guard_name' => "api",
		]);

		Role::create([
			'name'       => "Almacen",
			'guard_name' => "api",
		]);
		Role::create([
			'name'       => "Asignacion",
			'guard_name' => "api",
		]);
		Role::create([
			'name'       => "Transferencia",
			'guard_name' => "api",
		]);
		Role::create([
			'name'       => "Invitado",
			'guard_name' => "api",
		]);
	}
}
