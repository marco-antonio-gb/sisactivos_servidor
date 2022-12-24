<?php
namespace App\Http\Requests\Orgfinanciero;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
class StoreOrgfinancieroRequest extends FormRequest {
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
			'nombre' => 'required|string|unique:categorias|max:255',
		];
	}
	public function messages() {
		return [
			'nombre.required' => 'El nombre  es requerido',
			'nombre.string'   => 'El nombre debe ser un texto valido',
			'nombre.unique'   => 'El nombre ya fue registrado',
			'nombre.max'      => 'El nombre debe tener menos de 255 caracteres',
		];
	}
	protected function failedValidation(Validator $validator) {
		$erros = $validator->errors()->toArray();
		throw new HttpResponseException(response()->json([
			'success' => false,
			'errors'  => array_merge(...array_values($erros)),
		], 201));
	}
}
