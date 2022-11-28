<?php

namespace App\Http\Requests\Categoria;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreCategoriaRequest extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {

		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [

			'nombre'      => 'required|string|unique:categorias|max:255',
			'vida_util'   => 'required|integer|min:1|max:50',
			'descripcion' => 'required|string|max:255',
			'condicion'   => 'required|boolean',
		];
	}
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function messages() {
		return [
			'correo.required'   => 'Ingrese un correo  valido',
			'telefono.unique'   => 'El Nombre de usuario ya fue registrado',
			'telefono.max'      => 'El Nombre de usuario debe tener mas de 5 caracteres',
			'password.required' => 'La clave es obligatorio',
			'password.max'      => 'La clave debe ser menor que 35 caracteres.',
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
