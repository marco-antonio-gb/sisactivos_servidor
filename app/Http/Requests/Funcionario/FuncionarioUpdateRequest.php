<?php

namespace App\Http\Requests\Funcionario;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class FuncionarioUpdateRequest extends FormRequest
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
    
    public function rules()
    {
        return [
            'nombres'=>'required',
            'documento'=>'required',
        ];
    }

    public function messages() {
		return [
			'nombres.required' => 'El Nombre es obligatorio',
			'documento.required'   => 'Seleccione un documento para el Funcionario',
		];
	}


    protected function failedValidation(Validator $validator) {
		$erros = $validator->errors()->toArray();
		throw new HttpResponseException(response()->json([
			'success' => false,
			'errors'  => array_merge(...array_values($erros)),
		], 422));
	}
}
