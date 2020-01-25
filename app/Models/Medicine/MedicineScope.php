<?php

namespace App\Models\Medicine;
use Carbon\Carbon;

trait MedicineScope {

	public function scopeGood($query) {

		return $query->where('date', '>', Carbon::now()->format('Y-m-d'));
	}
}

?>
