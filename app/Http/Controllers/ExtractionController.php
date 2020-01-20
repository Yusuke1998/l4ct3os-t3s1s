<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExtractionStoreRequest;
use App\Models\Extraction\Extraction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExtractionController extends Controller {

	public $extraction;

	public function __construct() {

		$this->extraction = new Extraction();
	}

	public function index() {
		$extractions = Extraction::all();

		return response([
			'status' => 'success',
			'data' => $extractions,
		], 200);
	}

	public function tableComponent(Request $request) #revisar
	{
		$extractions = Extraction::orderBy('created_at','desc')->paginate(10);
		$data = Extraction::all();
		return response([
			'status' => 'success',
			'data' => $data,
			'pagination' => [
                'total'         => $extractions->total(),
                'current_page'  => $extractions->currentPage(),
            ]
		], 200);
	}

	public function stadisticsExtractions(Request $request) 
	{
		$todayExtractions = Extraction::today()->get();
		$fromDate = Carbon::now()->startOfWeek()->toDateString();
		$tillDate = Carbon::now()->toDateString();
		
		$weekExtractions = $this->extraction->getExtractionsForWeek($fromDate, $tillDate);
		$monthExtractions = $this->extraction->getExtractionsForMonth();
		$rangeExtractions = $this->extraction->getExtractionsForRange($request);

		return response([
			'status' 			=> 'success',
			'today_extractions' => $todayExtractions,
			'week_extractions' 	=> $weekExtractions,
			'month_extractions' => $monthExtractions,
			'range_extractions' => $rangeExtractions
		], 200);

	}

	public function create() {
		//
	}

	public function register(ExtractionStoreRequest $request) {
		$extraction = new Extraction();
		$extraction->create($request->except('_token'));

		return response([
			'status' => 'success',
			'data' => $extraction,
		], 200);
	}

	public function show(Extraction $extraction) {
		//
	}

	public function edit(Extraction $extraction) {
		//
	}

	public function update(ExtractionStoreRequest $request, Extraction $extraction) {
		$extraction->update($request->all());

		return response([
			'status' => 'success',
			'data' => $extraction,
		], 200);
	}

	public function delete(Extraction $extraction) {
		$extraction->delete();

		return response([
			'status' => 'success',
			'data' => $extraction,
		], 200);
	}
}
