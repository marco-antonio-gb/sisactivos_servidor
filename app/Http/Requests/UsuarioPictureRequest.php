<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
class UsuarioPictureRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules() {
		return [
			'foto'   => 'required',
            'usuario_id'  => 'required|numeric'
		];
	}
	public function messages() {
		return [

			'foto.required' => 'La imagen es obligatorio',


			'usuario_id.required'       => 'El identificador es obligatorio',
			'usuario_id.numeric'         => 'Ingrese un numero valido'
		];
	}
	public function failedValidation(Validator $validator) {
		$erros = $validator->errors()->toArray();
		throw new HttpResponseException(response()->json([
			'success' => false,
			'errors'  => array_merge(...array_values($erros)),
		], 422));
	}
}
