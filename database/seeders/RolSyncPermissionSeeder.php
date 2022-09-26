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
            'asignacion-create',
            'asignacion-read',
            'asignacion-update',
            'asignacion-delete',
            'transferencia-create',
            'transferencia-read',
            'transferencia-update',
            'transferencia-delete'
        ];
		$role1->syncPermissions($permissions1);
         
		
        
	}
}
