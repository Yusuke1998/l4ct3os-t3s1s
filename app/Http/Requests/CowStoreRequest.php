<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CowStoreRequest extends FormRequest {

	public function authorize() {
		return true;
	}

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
				'year_birth' => 'required',
				'weight' => 'required|between:0,99999.99',
				'code' => 'required|unique:cows',
			];

		}
	}

	public function messages() {

		return [
			'type.required' => 'El tipo de res es obligatorio',
			'year_birth.required' => 'El año es obligatorio',
			'weight.required' => 'El peso es obligatorio',
			'code.unique' => 'Este codigo ya existe',
			'code.required' => 'El codigo es requerido',

		];
	}

}
