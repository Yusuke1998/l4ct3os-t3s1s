<?php

namespace App\Http\Controllers;

use App\Http\Requests\VaccineStoreRequest;
use App\Models\Vaccine\Vaccine;
use Illuminate\Http\Request;

class VaccineController extends Controller {

	public function countTotalToday() {
		$total = Vaccine::today()->count();
		return response([
			'status' => 'success',
			'data' => $total,
		], 200);
	}

	public function datatable(Request $request, $perPage=5)
	{
		$order = isset($request->sort['order'])?$request->sort['order']:'desc';
		$fieldname = isset($request->sort['fieldName'])?$request->sort['fieldName']:'created_at';
		$filter = '%'.$request->filter.'%';

		$vaccines = Vaccine::where('quantity','LIKE',$filter)
			->orWhere('date','LIKE',$filter)
			->orWhereHas('employee',function($query) use ($filter){
				return $query
					->where('name','LIKE',$filter)
					->orWhere('identificacion_number','LIKE',$filter);
			})
			->orWhereHas('cow',function($query) use ($filter){
				return $query
					->where('type','LIKE',$filter)
					->orWhere('code','LIKE',$filter);
			})
			->orWhereHas('medicine',function($query) use ($filter){
				return $query
					->where('name_medicine','LIKE',$filter);
			})
			->orderBy($fieldname,$order)
			->paginate($perPage);

		return response([
			'pagination' => [
	            'totalPages'	=> ceil($vaccines->total()/$perPage),
	            'currentPage'	=> $vaccines->currentPage(),
	        ],
	        'data' => $vaccines->all()
    	], 200);
	}

	public function index() {
		$vaccines = Vaccine::all();
		return response([
			'status' => 'success',
			'data' => $vaccines,
		], 200);
	}

	public function register(VaccineStoreRequest $request) {
		$vaccine = new Vaccine();
		$vaccine->create($request->except('_token'));
		return response([
			'status' => 'success',
			'data' => $vaccine,
		], 200);
	}

	public function update(VaccineStoreRequest $request, Vaccine $vaccine){
		$vaccine->update($request->all());
		return response([
			'status' => 'success',
			'data' => $vaccine,
		], 200);
	}

	public function delete(Vaccine $vaccine) {
		$vaccine->delete();
		return response([
			'status' => 'success',
			'data' => $vaccine,
		], 200);
	}
}
