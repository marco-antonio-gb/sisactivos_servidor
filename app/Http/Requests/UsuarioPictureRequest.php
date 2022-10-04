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
			'foto'   => 'image|required|mimes:jpeg,png,jpg,gif',
            'usuario_id'  => 'required|numeric'
		];
	}
	public function messages() {
		return [
			'foto.image' => 'La archivo no es una imagen',
			'foto.required' => 'La imagen es obligatorio',
			 
			'foto.mimes'  => 'El archivo no es una imagen valida',
			
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
