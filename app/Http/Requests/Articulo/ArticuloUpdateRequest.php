<?php

namespace App\Http\Requests\Articulo;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ArticuloUpdateRequest extends FormRequest
{
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
			'codigo'           => ['required', 'string', 'min:18', 'max:20', Rule::unique('articulos')->ignore($this->articulo, 'idArticulo')],
			'foto'           => 'required',
			'unidad'           => 'required|string|max:10',
			'nombre'           => 'required|string|max:256',
			'categoria_id'     => 'required|integer',
			'orgfinanciero_id' => 'required|integer',
		];
	}
	public function messages() {
		return [
			'codigo.unique'             => 'El codigo ya fue registrado.',
			'codigo.required'           => 'El codigo es obligatorio.',
			'codigo.string'             => 'El codigo debe ser una cadena de texto.',
			'codigo.min'                => 'La longitud minima es de 18 Caracteres',
			'codigo.max'                => 'La longitud maxima es de 20 Caracteres',
			'codigo.unidad'             => 'El campo Unidad es obligatorio.',
			'imagen.required'             => 'La fotografia del Articulo es obligatoria.',
			'imagen.image'             => 'La fotografia debe ser una imagen valida del Articulo es obligatoria.',
			'unidad.required'           => 'La Unidad es obligatorio.',
			'unidad.string'             => 'La Unidad debe ser una cadena de texto.',
			'unidad.max'                => 'La unidad debe tener como maximo 10 Caracteres',
			'nombre.required'           => 'El nombre es obligatorio.',
			'nombre.string'             => 'El nombre debe ser una cadena de texto.',
			'nombre.max'                => 'El nombre debe tener un maximo de 256 Caracteres',
			'categoria_id.required'     => 'El identificador de Categoria es obligatorio.',
			'categoria_id.string'       => 'El identificador de Categoria debe ser un entero.',
			'orgfinanciero_id.required' => 'El identificador de Org. Financiero es obligatorio.',
			'orgfinanciero_id.string'   => 'El identificador de Org. Financiero debe ser un entero.',
		];
	}
	// protected function prepareForValidation() {
	// 	$datos = json_decode($this->request->get('data'), true);
	// 	$this->merge([
	// 		'codigo'           => $datos['codigo'],
	// 		'unidad'           => $datos['unidad'],
	// 		'nombre'           => $datos['nombre'],
	// 		'categoria_id'     => $datos['categoria_id'],
	// 		'orgfinanciero_id' => $datos['orgfinanciero_id']
	// 	]);
	// }
	protected function failedValidation(Validator $validator) {
		$erros = $validator->errors()->toArray();
		throw new HttpResponseException(response()->json([
			'success' => false,
			'errors'  => array_merge(...array_values($erros)),
		]));
	}
}
