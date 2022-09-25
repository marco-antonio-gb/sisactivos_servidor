<?php
/*
 * Copyright (c) 2021.  modem.ff@gmail.com | Marco Antonio Gutierrez Beltran
 */
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$permissions = [
			'usuario-list',
			'usuario-create',
			'usuario-update',
			'usuario-delete',
			'usuario-lock',
			#--------------
			'rol-list',
			'rol-create',
			'rol-update',
			'rol-delete',
			#--------------
			'permiso-list',
			'permiso-create',
			'permiso-update',
			'permiso-delete',
			#--------------
			'asignar-rol',
			'asignar-permiso',
			#--------------
			'paciente-create',
			'paciente-update',
			'paciente-list',
			'paciente-delete',
            #--------------
			'persona-create',
			'persona-update',
			'persona-list',
			'persona-delete',
            #--------------
			'historial-create',
			'historial-delete',
			'historial-update',
			'historial-list',

			'medico-create',
			'medico-list',
			'medico-update',
			'medico-delete',
		];

		foreach ($permissions as $permission) {
			Permission::create(['name' => $permission]);
		}

	}
}
