<?php

namespace App\Models\Vaccine;

trait VaccineScope {

	public function scopeToday($query) {
		$query->where('date', date('Y-m-d'));
	}
}
?>
