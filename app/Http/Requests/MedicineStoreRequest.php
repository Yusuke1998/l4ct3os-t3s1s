<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedicineStoreRequest extends FormRequest {

	public function authorize() {
		return true;
	}

	public function rules() {

		$id = get_model_id($this, 'medicine');

		if ($id) {
			return [
				'name_medicine'	=> 'required|string',
				'date' 			=> 'required|date'
			];

		} else {
			return [
				'name_medicine'	=> 'required|string',
				'date' 			=> 'required|date'
			];

		}
	}

	public function messages() {

		return [
			'name_medicine.required'	=> 'El nombre es obligatorio',
			'name_medicine.string'		=> 'El nombre debe ser un texto',
			'date.required'				=> 'La fecha de vencimiento es obligatoria',
			'date.date'					=> 'La fecha no tiene formato valido',
		];
	}
}
