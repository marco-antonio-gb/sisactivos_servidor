<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;


class AsignacionUpdateRequest extends FormRequest
{
    public function authorize() {
		return true;
	}


    public function rules() {
		return [
			'responsable_id' => 'required',
			'usuario_id' => 'required',
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
