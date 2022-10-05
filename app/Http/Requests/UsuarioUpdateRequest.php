<?php
namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Tymon\JWTAuth\Contracts\Providers\Auth;

class UsuarioUpdateRequest extends FormRequest {


	public function authorize() {

		return true;
	}

	public function rules() {

		return [
			'paterno'   => 'required|string|between:2,100',
			'materno'   => 'required|string|between:2,100',
			'nombres'   => 'required|string|between:2,100',
			'direccion' => 'required|string|max:50',
			'ci_ext'    => 'required|string|max:9',
			'cargo'     => 'required|string|between:2,30',
			'ci'        => ['required', 'string', 'max:9', Rule::unique('usuarios')->ignore($this->usuario, 'idUsuario')],
			'correo'    => ['required', 'string', 'email', 'max:100', Rule::unique('usuarios')->ignore($this->usuario, 'idUsuario')],
			'telefono'  => ['required', 'string', 'max:15', Rule::unique('usuarios')->ignore($this->usuario, 'idUsuario')],


		];
	}
	public function messages() {
		return [
			'telefono.required' => 'El Numero de Telefono es obligatorio',
			'telefono.unique'   => 'El Numero de Telefono ya fue registrado',
			'telefono.max'      => 'El Numero de Telefono debe tener 15 caracteres',
			'nombres.required'  => 'El Nombre es obligatorio',
			'nombres.max'       => 'El Apellido paterno debe ser menor que 50 caracteres.',
			'paterno.required'  => 'El Apellido Paterno es obligatorio',
			'paterno.max'       => 'El Apellido paterno debe ser menor que 50 caracteres.',
			'materno.required'  => 'El Apellido Materno es obligatorio',
			'materno.max'       => 'El Apellido paterno debe ser menor que 50 caracteres.',
			'correo.email'      => 'Ingrese un correo valido',
			'correo.unique'     => 'El Correo ya fue registrado',

			'ci.required'       => 'El Numero de Cedula ya fue registrado',
			'ci.unique'         => 'El Numero de Cedula ya fue registrado',
		];
	}
	protected function failedValidation(Validator $validator) {
		$erros = $validator->errors()->toArray();
		throw new HttpResponseException(response()->json([
			'success' => false,
			'update'  => true,
			'errors'  => array_merge(...array_values($erros)),
		], 200));
	}
}
