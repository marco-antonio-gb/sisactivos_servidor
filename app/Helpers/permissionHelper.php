<?php

use App\Models\Usuario;

function getAllPermissions($id) {
	try {
		$user = Usuario::find($id);
		if ($user) {
			$permisos = $user->getPermissionNames();
			if ($permisos->isEmpty()) {
				return "No existen permisos para este usuario";
			} else {
				return $permisos;
			}
		} else {
			return 'No existen resultados';
		}
	} catch (\Exception $ex) {
		return $ex->getMessage();
	}
}
function getAllRoles($id) {
	try {
		$user = Usuario::find($id);
		if ($user) {
			$permisos = $user->roles->pluck('name');
			if ($permisos->isEmpty()) {
				return "No existen roles para este usuario";
			} else {
				return $permisos;
			}
		} else {
			return 'No existen resultados';
		}
	} catch (\Exception $ex) {
		return $ex->getMessage();
	}
}
?>