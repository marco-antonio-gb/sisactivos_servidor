<?php
namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ServicioStoreRequest extends FormRequest {
	public function authorize() {
		return true;
	}
	public function rules() {
		return [
			'nombre' => 'required|string|between:2,100',
			'codigo' => 'required|string|max:10|unique:servicios',
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
