<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeStoreRequest;
use App\Models\Employee\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller {

	public function datatable(Request $request, $perPage=5)
	{
		$order = isset($request->sort['order'])?$request->sort['order']:'desc';
		$fieldname = isset($request->sort['fieldName'])?$request->sort['fieldName']:'created_at';
		$filter = '%'.$request->filter.'%';

		$extractions = Employee::where('name','LIKE',$filter)
			->orWhere('identificacion_number','LIKE',$filter)
			->orWhere('position','LIKE',$filter)
			->orWhere('date_birth','LIKE',$filter)
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

	public function index($position = null) {

		if ($position) {
			$employees = Employee::position($position)->get();
		} else {
			$employees = Employee::with('accounts')->get();
		}

		return response([
			'status' => 'success',
			'data' => $employees,
		], 200);
	}

	public function ci($ci)
	{
		$employee = Employee::where('identificacion_number',$ci)->first();
		return response([
			'status' => 'success',
			'data' => $employee,
		], 200);
	}

	public function register(EmployeeStoreRequest $request) {
		$employee = new Employee();
		$employee->create($request->except('_token'));

		return response([
			'status' => 'success',
			'data' => $employee,
		], 200);

	}

	public function update(EmployeeStoreRequest $request, Employee $employee) {
		$employee->update($request->all());

		return response([
			'status' => 'success',
			'data' => $employee,
		], 200);

	}

	public function delete(Employee $employee) {
		$employee->delete();

		return response([
			'status' => 'success',
			'data' => $employee,
		], 200);

	}
}
