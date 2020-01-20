<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VaccineStoreRequest extends FormRequest {

	public function authorize() {
		return true;
	}

	public function rules() {

		$id = get_model_id($this, 'vaccine');

		if ($id) {
			return [
				'employee_id'	=> 'required',
				'cow_id'		=> 'required',
				'medicine_id'	=> 'required',
				'quantity'		=> 'required',
				'date'			=> 'required|date'
			];
		} else {
			return [
				'employee_id'	=> 'required',
				'cow_id'		=> 'required',
				'medicine_id'	=> 'required',
				'quantity'		=> 'required',
				'date'			=> 'required|date'
			];
		}
	}

	public function messages() {

		return [
				'employee_id.required'	=> 'El vacunador es requerido',
				'cow_id.required'		=> 'La res es requerida',
				'medicine_id.required'	=> 'La medicina es requerida',
				'quantity.required'		=> 'La cantidad administrada es requerida',
				'date.required' 		=> 'La fecha es requerida',
				'date.date' 			=> 'La fecha no tiene un formato valido'
		];
	}
}
