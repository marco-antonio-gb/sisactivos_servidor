<?php

namespace App\Http\Requests\DetalleAsignacion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreDetalleAsignacionRequest extends FormRequest {
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
            'asignacion_id' => 'required|integer',
            'articulo_id' => 'required|integer',
            'detalle' => 'required|string|max:200'
		];
	}
    public function messages() {
		return [
			'asignacion_id.required' => 'La asignacion es requerida.',
			'asignacion_id.integer'  => 'El tipo de identificador es invalido.',
			'articulo_id.required'   => 'El articulo es requerido.',
			'articulo_id.integer'    => 'El tipo de identificador es invalido.',
			'detalle.required'       => 'El detalle es requerido.',
			'detalle.string'         => 'El tipo de dato es invalido.',
			'detalle.max'            => 'El tipo de dato es invalido.',

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
