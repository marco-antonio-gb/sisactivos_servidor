<?php
namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ArticuloStoreRequest extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}
	public function rules() {
		return [

			'codigo'           => 'required',
			'unidad'           => 'required',
			'nombre'           => 'required',
			'imagen'           => 'required',
			'categoria_id'     => 'required',
			'orgfinanciero_id' => 'required',

		];
	}
	protected function prepareForValidation() {
		$datos = json_decode($this->request->get('data'), true);
		$this->merge([
			'codigo'           => $datos['codigo'],
			'unidad'           => $datos['unidad'],
			'nombre'           => $datos['nombre'],
			'imagen'           => $this->request->get('imagen'),
			'categoria_id'     => $datos['categoria_id'],
			'orgfinanciero_id' => $datos['orgfinanciero_id'],

		]);
	}
	protected function failedValidation(Validator $validator) {
		$erros = $validator->errors()->toArray();
		throw new HttpResponseException(response()->json([
			'success' => false,
			'errors'  => array_merge(...array_values($erros)),
		], 422));
	}
}
