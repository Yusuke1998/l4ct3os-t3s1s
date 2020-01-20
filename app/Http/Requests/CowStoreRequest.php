<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CowStoreRequest extends FormRequest {
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

		$id = get_model_id($this, 'cow');

		if ($id) {
			return [
				'type' => 'required',
				'year_birth' => 'required',
				'weight' => 'required|between:0,99999.99',
				'code' => 'required|unique:cows,code,' . $id,
			];

		} else {
			return [
				'type' => 'required',
				'year_birth' => 'required|date',
				'weight' => 'required|between:0,99999.99',
				'code' => 'required|unique:cows',
			];

		}
	}

	public function messages() {

		return [
			'type.required' => 'El tipo de res es obligatorio',
			'year_birth.required' => 'El año es obligatorio',
			'year_birth.date' => 'El año no tiene un formato valido',
			'weight.required' => 'El peso es obligatorio',
			'code.unique' => 'Este codigo ya existe',
			'code.required' => 'El codigo es requerido',

		];
	}

}
