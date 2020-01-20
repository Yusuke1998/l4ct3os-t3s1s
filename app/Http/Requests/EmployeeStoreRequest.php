<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeStoreRequest extends FormRequest {
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

		$id = get_model_id($this, 'employee');

		if ($id) {
			return [
				'name' => 'required|string',
				'position' => 'required|string',
				'date_birth' => 'required|date',
				'identificacion_number' => 'required|unique:employees,identificacion_number,' . $id,
			];

		} else {
			return [
				'name' => 'required|string',
				'position' => 'required|string',
				'date_birth' => 'required|date',
				'identificacion_number' => 'required|unique:employees|min:7|max:8',
			];

		}
	}

	public function messages() {
		return [
			'name.required' => 'El nombre es obligatorio',
			'position.required' => 'El cargo es obligatorio',
			'date_birth.required' => 'La fecha de nacimiento es obligatoria',
			'date_birth.date' => 'La fecha no tiene un formato valido',
			'identificacion_number.min' => 'La cedula debe tener al menos 7 caracteres',
			'identificacion_number.max' => 'La cedula debe tener maximo 8 caracteres',
			'identificacion_number.unique' => 'Esta cedula ya fue registrada',
		];
	}

	public function response(array $errors) {
		if ($this->expectsJson()) {
			return new JsonResponse($errors, 422);
		}

		return $this->redirector->to($this->getRedirectUrl())
			->withInput($this->except($this->dontFlash))
			->withErrors($errors, $this->errorBag);
	}
}
