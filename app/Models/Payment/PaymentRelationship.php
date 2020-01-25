<?php

namespace App\Models\Payment;

use App\Models\Employee\Employee;
use App\Models\Account\Account;
use App\Models\User\User;

trait PaymentRelationship {

	public function employee(){
		return $this->belongsTo(Employee::class);
	}

	public function account(){
		return $this->belongsTo(Account::class);
	}

	public function user(){
		return $this->belongsTo(User::class);
	}
}

?>