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
			'username'  => 'required|string|max:25',
			'password'  => 'required|string|max:25',
		];
	}
	public function messages() {
		return [
			'username.required' => 'Ingrese un nombre de usuario valido',
			'telefono.unique'   => 'El Nombre de usuario ya fue registrado',
			'telefono.max'      => 'El Nombre de usuario debe tener mas de 5 caracteres',
			'password.required'  => 'La clave es obligatorio',
			'password.max'       => 'La clave debe ser menor que 25 caracteres.',
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