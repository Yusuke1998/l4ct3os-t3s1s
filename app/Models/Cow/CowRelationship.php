<?php

namespace App\Models\Cow;

use App\Models\Cow\Cow;
use App\Models\Extraction\Extraction;
use App\Models\Vaccine\Vaccine;

trait CowRelationship {

	public function extractions() {
		return $this->hasMany(Extraction::class);
	}

	public function vaccines() {
		return $this->hasMany(Vaccine::class);
	}
}

?>