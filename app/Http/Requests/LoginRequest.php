<?php
namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
class LoginRequest extends FormRequest {
	public function authorize() {
		return true;
	}
	public function rules() {
		return [
			'correo'  => 'required|email|string|max:35',
			'password'  => 'required|string|max:35',
		];
	}
	public function messages() {
		return [
			'correo.required' => 'Ingrese un correo  valido',
			'telefono.unique'   => 'El Nombre de usuario ya fue registrado',
			'telefono.max'      => 'El Nombre de usuario debe tener mas de 5 caracteres',
			'password.required'  => 'La clave es obligatorio',
			'password.max'       => 'La clave debe ser menor que 35 caracteres.',
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
