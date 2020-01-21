<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeStoreRequest;
use App\Models\Employee\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller {

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
