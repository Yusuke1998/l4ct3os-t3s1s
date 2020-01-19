<?php

namespace App\Models\Extraction;
use Carbon\Carbon;

trait ExtractionMethod {

	public function getExtractionsForWeek($initialDate, $finalDate) {
		$days = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];
		$registers = [];
		$weekExtractions = $this::whereBetween('date', [$initialDate, $finalDate])->get();
		foreach ($weekExtractions as $extraction) {

			$date = new Carbon($extraction->date);
			$value = $registers[$days[$date->dayOfWeek]] ?? 0;
			$registers[$days[$date->dayOfWeek]] = $value + $extraction->quantity;
		}
		return $registers;
	}

	public function getExtractionsForMonth() {
		$actualMonth = Carbon::now()->month;
		$lapsus = ['Semana 1', 'Semana 2', 'Semana 3', 'Semana 4', 'Semana 5'];
		$registers = [];
		$monthExtractions = $this::whereMonth('date', $actualMonth)->get();
		foreach ($monthExtractions as $extraction) {

			$date = new Carbon($extraction->date);
			$value = $registers[$lapsus[$date->weekOfMonth - 1]] ?? 0;
			$registers[$lapsus[$date->weekOfMonth - 1]] = $value + $extraction->quantity;
		}
		return $registers;
	}
	
	public function getExtractionsForRange($request) {
		$registers = [];
		$months = [
				'01'=>'Enero', '02'=>'Febrero', '03'=>'Marzo', 
				'04'=>'Abril', '05'=>'Mayo', '06'=>'Junio', 
				'07'=>'Julio', '08'=>'Agosto', '09'=>'Septiembre',
				'10'=>'Octubre', '11'=>'Noviembre', '12'=>'Diciembre'
		];
		if (!is_null($request->range['from'])&&!is_null($request->range['to'])) {
			$monthExtractions = $this::whereBetween('date', [
				$request->range['from'], $request->range['to']
			])->get();
			foreach ($monthExtractions as $extraction) {
				$date = new Carbon($extraction->date);
				$value = $registers[$months[$date->format('m')]] ?? 0;
				$registers[$months[$date->format('m')]] = $value + $extraction->quantity;
			}
			return $registers;
		}
		return $registers;
	}
}

?>