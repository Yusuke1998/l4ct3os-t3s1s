<?php

namespace App\Models\Medicine;

use App\Models\Medicine\MedicineMutator;
use App\Models\Medicine\MedicineRelationship;
use App\Models\Medicine\MedicineScope;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model {

	use MedicineScope,
	MedicineRelationship,
		MedicineMutator;

	protected $guarded = [];
	// protected $appends = ['name_employee', 'code_cow'];
}
