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

	public function datatable(Request $request, $perPage=5)
	{
		$order = isset($request->sort['order'])?$request->sort['order']:'desc';
		$fieldname = isset($request->sort['fieldName'])?$request->sort['fieldName']:'created_at';
		$filter = '%'.$request->filter.'%';

		$extractions = Extraction::with('employee','cow')
			->where('quantity','LIKE',$filter)
			->orWhere('date','LIKE',$filter)
			->orWhereHas('employee',function($query) use ($filter){
				return $query
					->where('name','LIKE',$filter)
					->orWhere('identificacion_number','LIKE',$filter);
			})
			->orWhereHas('cow',function($query) use ($filter){
				return $query
				->where('year_birth','LIKE',$filter)
				->orWhere('weight','LIKE',$filter)
				->orWhere('type','LIKE',$filter)
				->orWhere('code','LIKE',$filter);
			})
			->orderBy($fieldname,$order)
			->paginate($perPage);

		return response([
			'pagination' => [
	            'totalPages'	=> ceil($extractions->total()/$perPage),
	            'currentPage'	=> $extractions->currentPage(),
	        ],
	        'data' => $extractions->all()
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
