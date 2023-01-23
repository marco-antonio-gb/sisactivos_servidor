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
			'escritorio',
            'almacen-create',
            'almacen-read',
            'almacen-update',
            'almacen-delete',
            'asignacion-create',
            'asignacion-read',
            'asignacion-update',
            'asignacion-delete',
            'transferencia-create',
            'transferencia-read',
            'transferencia-update',
            'transferencia-delete',
		];
		foreach ($permissions as $permission) {
			Permission::create(['name' => $permission]);
		}
	}
}
