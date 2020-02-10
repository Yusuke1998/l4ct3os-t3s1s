<?php

namespace App\Models\Cow;
use App\Models\Cow\CowMutator;
use App\Models\Cow\CowScope;
use App\Models\Cow\CowRelationship;
use Illuminate\Database\Eloquent\Model;

class Cow extends Model {
	use CowMutator,
		CowScope,
		CowRelationship;

	protected $guarded = [];
	protected $appends = ['ordeno'];

	public static function cowStatistics() {

		$labels = ['girolando', 'holstein', 'brahman', 'pardo_suizo'];
		$counts = [];

		foreach ($labels as $label) {

			$countTypeCows = self::where('type', $label)->count();
			$counts[] = $countTypeCows;
		}

		$datasets = ['label' => 'Tipos de Reses', 'data' => $counts];
		$data = ['labels' => $labels, 'datasets' => [$datasets]];

		return json_encode($data);
	}

}
