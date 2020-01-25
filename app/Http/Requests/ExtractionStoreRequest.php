<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExtractionStoreRequest extends FormRequest {
	
	public function authorize() {
		return true;
	}

	public function rules() {

		$id = get_model_id($this, 'extraction');

		if ($id) {
			return [
				'quantity' 		=> 'required|between:0,99999.99',
				'employee_id' 	=> 'required',
				'cow_id' 		=> 'required',
				'date' 			=> 'required',
			];

		} else {
			return [
				'quantity' => 'required|between:0,99999.99',
				'employee_id' 	=> 'required',
				'cow_id' 		=> 'required',
				'date' 			=> 'required',
			];

		}
	}

	public function messages() {

		return [
			'quantity.required' 	=> 'La cantidad es obligatoria',
			'employee_id.required' 	=> 'El ordeñador es obligatorio',
			'cow_id.required' 		=> 'La res es obligatoria',
			'date.required' 		=> 'La fecha es obligatoria',

		];
	}}
