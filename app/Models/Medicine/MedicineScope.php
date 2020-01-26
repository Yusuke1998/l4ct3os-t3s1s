<?php

namespace App\Models\Medicine;
use Carbon\Carbon;

trait MedicineScope {

	public function scopeGood($query) {

		return $query->where('date', '>', date('Y-m-d'))
					->where('quantity','>','0');
	}
}

?>
