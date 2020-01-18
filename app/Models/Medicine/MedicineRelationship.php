<?php

namespace App\Models\Medicine;
use App\Models\Vaccine\Vaccine;

trait MedicineRelationship {

	public function vaccines() {
		return $this->hasMany(Vaccine::class);
	}
}

?>