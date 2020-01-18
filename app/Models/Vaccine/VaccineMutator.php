<?php

namespace App\Models\Vaccine;

trait VaccineMutator {

	public function getNameEmployeeAttribute() {
		return $this->employee->name ?? '';
	}

	public function getNameMedicineAttribute() {
		return $this->medicine->name_medicine ?? '';
	}

	public function getCodeCowAttribute() {
		return $this->cow->code ?? '';
	}

}

?>