<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicineStoreRequest;
use App\Models\Medicine\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
	public function datatable(Request $request, $perPage=5)
	{
		$order = isset($request->sort['order'])?$request->sort['order']:'desc';
		$fieldname = isset($request->sort['fieldName'])?$request->sort['fieldName']:'created_at';
		$filter = '%'.$request->filter.'%';

		$medicines = Medicine::where('name_medicine','LIKE',$filter)
			->orWhere('date','LIKE',$filter)
			->orderBy($fieldname,$order)
			->paginate($perPage);

		return response([
			'pagination' => [
	            'totalPages'	=> ceil($medicines->total()/$perPage),
	            'currentPage'	=> $medicines->currentPage(),
	        ],
	        'data' => $medicines->all()
    	], 200);
	}

    public function index($good=null)
    {
    	$medicines = (!isset($good))?Medicine::all():Medicine::good()->get();
		return response([
			'status' => 'success',
			'data' => $medicines,
		], 200);
	}

	public function register(MedicineStoreRequest $request)
	{
		$medicine = new Medicine();
		$medicine->create($request->except('_token'));

		return response([
			'status' => 'success',
			'data' => $medicine,
		], 200);

	}

	public function update(MedicineStoreRequest $request, Medicine $medicine)
	{
		$medicine->update($request->all());

		return response([
			'status' => 'success',
			'data' => $medicine,
		], 200);

	}

	public function delete(Medicine $medicine) {
		$medicine->delete();

		return response([
			'status' => 'success',
			'data' => $medicine,
		], 200);
	}
}
