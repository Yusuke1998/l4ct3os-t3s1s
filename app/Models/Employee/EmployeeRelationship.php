<?php

namespace App\Models\Employee;

use App\Models\Extraction\Extraction;
use App\Models\Payment\Payment;
use App\Models\Account\Account;

trait EmployeeRelationship {

	public function extractions() {
		return $this->hasMany(Extraction::class);
	}

	public function payments(){
    	return $this->hasMany(Payment::class);
    }

    public function accounts(){
    	return $this->hasMany(Account::class);
    }
}

?>