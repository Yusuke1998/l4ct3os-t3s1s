<?php

namespace App\Models\Vaccine;

use App\Models\Vaccine\VaccineMutator;
use App\Models\Vaccine\VaccineRelationship;
use App\Models\Vaccine\VaccineScope;
use Illuminate\Database\Eloquent\Model;

class Vaccine extends Model {

	use VaccineScope,
	VaccineRelationship,
		VaccineMutator;

	protected $guarded = [];
	protected $appends = ['name_employee', 'code_cow', 'name_medicine'];
}
