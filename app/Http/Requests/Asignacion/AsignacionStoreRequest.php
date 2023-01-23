<?php

namespace App\Http\Requests\Asignacion;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AsignacionStoreRequest extends FormRequest {
	public function authorize() {
		return true;
	}
	public function rules() {
		return [
			'responsable_id' => 'required',
			'usuario_id'     => 'required',
			'articulos'    => 'required',

		];
	}
	protected function failedValidation(Validator $validator) {
		$erros = $validator->errors()->toArray();
		throw new HttpResponseException(response()->json([
			'success' => false,
			'errors'  => array_merge(...array_values($erros)),
		], 200));
	}
}
