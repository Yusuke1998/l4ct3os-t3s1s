<?php

namespace App\Models\Account;

trait AccountScope {

	public function scopeWorker($query, $employee_id) {
		return $query->where('employee_id', '=', $employee_id);
	}
}

?>