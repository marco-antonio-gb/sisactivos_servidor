<?php

namespace App\Http\Requests\persona;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdatePersona extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
		return [
			'nombres' => 'required|max:50',
			'paterno' => 'required|max:50',
			'materno' => 'required|max:50',
			'ci'      => 'required|max:11|min:7',
			'correo'  => 'required|email|max:50|',
			'fec_nac' => 'required|date|date_format:Y-m-d|before:today',
		];
	}
	public function messages() {
		return [
			'nombres.required' => 'El nombre es obligatorio',
			'nombres.max'      => 'El apellido paterno debe ser menor que 50 caracteres.',
			'paterno.required' => 'El apellido Paterno es obligatorio',
			'paterno.max'      => 'El apellido paterno debe ser menor que 50 caracteres.',
			'materno.required' => 'El apellido Materno es obligatorio',
			'materno.max'      => 'El apellido paterno debe ser menor que 50 caracteres.',
			'correo.email'     => 'Ingrese un correo valido',
			'correo.unique'    => 'El correo ya existe',
			'ci.required'      => 'El Numero de Cedula ya existe',
			'ci.unique'        => 'El Numero de Cedula ya existe',
			'fec_nac.before'   => 'La fecha de Nacimiento es incorrecta',
		];
	}

	protected function failedValidation(Validator $validator) {
		throw new HttpResponseException(response()->json($validator->errors(), 422));
	}
}
