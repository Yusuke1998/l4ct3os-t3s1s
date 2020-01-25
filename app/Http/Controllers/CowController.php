<?php

namespace App\Http\Controllers;

use App\Http\Requests\CowStoreRequest;
use App\Models\Cow\Cow;
use Illuminate\Http\Request;

class CowController extends Controller {

	public function countTotal() {

		$total = Cow::count();

		return response([
			'status' => 'success',
			'data' => $total,
		], 200);

	}

	public function statisticsCows() {

		$statistics = Cow::cowStatistics();

		return response([
			'status' => 'success',
			'data' => $statistics,
		], 200);

	}

	public function datatable(Request $request, $perPage=5)
	{
		$order = isset($request->sort['order'])?$request->sort['order']:'desc';
		$fieldname = isset($request->sort['fieldName'])?$request->sort['fieldName']:'created_at';
		$filter = '%'.$request->filter.'%';

		$cows = Cow::where('year_birth','LIKE',$filter)
			->orWhere('weight','LIKE',$filter)
			->orWhere('type','LIKE',$filter)
			->orWhere('code','LIKE',$filter)
			->orderBy($fieldname,$order)
			->paginate($perPage);

		return response([
			'pagination' => [
	            'totalPages'	=> ceil($cows->total()/$perPage),
	            'currentPage'	=> $cows->currentPage(),
	        ],
	        'data' => $cows->all()
    	], 200);
	}

	public function index($milking = null) {
		if ($milking) {
			$cows = Cow::milking()->get();
		} else {
			$cows = Cow::all();
		}
		return response([
			'status' => 'success',
			'data' => $cows,
		], 200);
	}

	public function register(CowStoreRequest $request) {
		$cow = new Cow();
		$cow->create($request->except('_token'));

		return response([
			'status' => 'success',
			'data' => $cow,
		], 200);
	}

	public function update(CowStoreRequest $request, Cow $cow) {
		$cow->update($request->all());
		return response([
			'status' => 'success',
			'data' => $cow,
		], 200);
	}

	public function delete(Cow $cow) {
		$cow->delete();
		return response([
			'status' => 'success',
			'data' => $cow,
		], 200);
	}
}
