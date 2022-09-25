<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RolSyncPermissionSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
         
		$role1        = Role::find('2');
		$permissions1 = [
            'paciente-create',
            'paciente-update',
            'paciente-list',
            'paciente-delete',

            'historial-create',
            'historial-delete',
            'historial-update',
            'historial-list',
        ];
		$role1->syncPermissions($permissions1);
         
		$role2        = Role::find('3');
		$permissions2 = [
			'paciente-create',
            'paciente-update',
            'paciente-list',
            'paciente-delete',
        ];
		$role2->syncPermissions($permissions2);
        
        $role3        = Role::find('4');
		$permissions3 = [
			'paciente-create',
            'paciente-update',
            'paciente-list',
            'paciente-delete',
        ];
		$role3->syncPermissions($permissions3);

        $role4        = Role::find('5');
		$permissions4 = [
			'paciente-create',
            'paciente-update',
            'paciente-list',
            'paciente-delete',
        ];
		$role4->syncPermissions($permissions4);
        
	}
}
