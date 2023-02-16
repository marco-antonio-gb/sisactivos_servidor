<?php
namespace App\Http\Requests\Baja;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BajaStoreRequest extends FormRequest {
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
			"responsable_id" => 'required',
			"articulo_id"    => 'required',
			"motivo"    => 'required',
			"informe_baja"    => 'required',
		];
	}
	public function messages() {
		return [
			'responsable_id.required' => 'El responsable es obligatorio',
			'articulo_id.required'    => 'Seleccione al menos un articulo',
			'motivo.required'    => 'Ingrese el motivo de la baja',
			'informe_baja.required'    => 'Ingrese un informe de baja'
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
