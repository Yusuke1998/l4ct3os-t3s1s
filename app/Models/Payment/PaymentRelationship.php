<?php

namespace App\Models\Payment;

use App\Models\Employee\Employee;
use App\Models\Account\Account;

trait PaymentRelationship {

	public function employee(){
		return $this->belongsTo(Employee::class);
	}

	public function account(){
		return $this->belongsTo(Account::class);
	}
}

?>