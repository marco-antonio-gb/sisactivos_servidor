<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class PermisoStoreRequest extends FormRequest {
	 
	public function authorize() {
		return true;
	}
	 
	public function rules() {
		return [
			'name' => 'required|unique:permissions',
		];
	}
	public function messages() {
		return [
			'name.required' => 'El Nombre es obligatorio',
			'name.unique'   => 'El Nombre de permiso ya fue registrado',
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
