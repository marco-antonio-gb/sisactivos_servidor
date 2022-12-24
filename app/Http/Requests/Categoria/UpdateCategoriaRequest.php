<?php
namespace App\Http\Requests\Categoria;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;

class UpdateCategoriaRequest extends FormRequest {
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
			'nombre'      => ['required', 'string', 'max:255', Rule::unique('categorias')->ignore($this->categoria, 'idCategoria')],
			'vida_util'   => 'required|integer|min:1|max:50',
			'descripcion' => 'required|string|max:255',
		];
	}
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function messages() {
		return [
			'nombre.required'      => 'El nombre de categoria es requerido',
			'nombre.string'        => 'El nombre debe ser un texto valido',
			'nombre.unique'        => 'El nombre ya fue registrado',
			'nombre.max'           => 'El nombre debe tener menos de 255 caracteres',

			'vida_util.required'   => 'La vida tuil es requerido',
			'vida_util.integer'    => 'La vida util, debe ser un numero entero',
			'vida_util.min'        => 'La vida util debe ser mayor a cero',
			'vida_util.max'        => 'La vida util, debe ser menor a 50',

			'descripcion.required' => 'La descripcion es requerida',
			'descripcion.string'   => 'La descripcion debe ser un texto valido',
			'descripcion.max'      => 'La descripcion debe ser menor a 50',
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
