<?php

namespace App\Models\Employee;

use App\Models\Employee\EmployeeMutator;
use App\Models\Employee\EmployeeScope;
use App\Models\Employee\EmployeeRelationship;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model {

	use EmployeeRelationship,
		EmployeeMutator,
		EmployeeScope;

	protected $guarded = [];

	protected $appends = ['age', 'cargo'];

}
