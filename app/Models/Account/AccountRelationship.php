<?php

namespace App\Models\Account;

use App\Models\Employee\Employee;
use App\Models\Payment\Payment;

trait AccountRelationship {

	public function employee() {
		return $this->belongsTo(Employee::class);
	}

	public function payments() {
		return $this->hasMany(Payment::class);
	}
}

?>