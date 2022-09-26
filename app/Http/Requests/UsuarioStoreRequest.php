<?php
namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
class UsuarioStoreRequest extends FormRequest {
	public function authorize() {
		return true;
	}
	public function rules() {
		return [
			'paterno'   => 'required|string|between:2,100',
			'materno'   => 'required|string|between:2,100',
			'nombres'   => 'required|string|between:2,100',
			'direccion' => 'required|string|max:20',
			'ci'        => 'required|string|max:9|unique:usuarios',
			'ci_ext'    => 'required|string|max:9',
			'cargo'     => 'required|string|between:2,30',
			'correo'    => 'required|string|email|max:100|unique:usuarios',
			'telefono'  => 'required|string|max:5|unique:usuarios',
			'username'  => 'required|string|max:25|unique:usuarios',
			'password'  => 'required|string|max:25',
            'roles'     => 'required',
            'permisos'  => 'required'
		];
	}
	public function messages() {
		return [
			'telefono.required' => 'El Numero de Telefono es obligatorio',
			'telefono.unique'   => 'El Numero de Telefono ya fue registrado',
			'telefono.max'      => 'El Numero de Telefono debe tener 5 caracteres',
			'nombres.required'  => 'El Nombre es obligatorio',
			'nombres.max'       => 'El Apellido paterno debe ser menor que 50 caracteres.',
			'paterno.required'  => 'El Apellido Paterno es obligatorio',
			'paterno.max'       => 'El Apellido paterno debe ser menor que 50 caracteres.',
			'materno.required'  => 'El Apellido Materno es obligatorio',
			'materno.max'       => 'El Apellido paterno debe ser menor que 50 caracteres.',
			'correo.email'      => 'Ingrese un correo valido',
			'correo.unique'     => 'El Correo ya existe',
			'username.unique'   => 'El Nombre de usuario ya existe',
			'ci.required'       => 'El Numero de Cedula ya existe',
			'ci.unique'         => 'El Numero de Cedula ya existe',
            'roles.required'    => 'Ingrese al menos un Rol',
            'permisos.required'    => 'Ingrese al menos un Permiso'
			// 'fec_nac.before'   => 'La fecha de Nacimiento es incorrecta',
		];
	}
	protected function failedValidation(Validator $validator) {
		$erros = $validator->errors()->toArray();
		throw new HttpResponseException(response()->json([
			'success' => false,
			'errors'  => array_merge(...array_values($erros)),
		], 422));
	}
}
