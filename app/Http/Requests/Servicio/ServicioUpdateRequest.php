<?php
namespace App\Http\Requests\Servicio;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;


use Illuminate\Http\Exceptions\HttpResponseException;

class ServicioUpdateRequest extends FormRequest {
	public function authorize() {
		return true;
	}
	public function rules() {
		return [
			'nombre' => 'required|string|between:2,100',
			// 'codigo' => 'required|string|max:10|unique:servicios',
            'codigo'      => ['required', 'string', 'max:15', Rule::unique('servicios')->ignore($this->servicio, 'idServicio')],
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
