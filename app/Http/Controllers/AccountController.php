<?php

namespace App\Http\Controllers;

use App\Models\Account\Account;
use App\Models\Employee\Employee;
use Illuminate\Http\Request;
use App\Http\Requests\EmployeeStoreRequest;

class AccountController extends Controller
{
    public function index($employee_id)
    {
    	$accounts = Account::worker($employee_id)->get();
		return response([
			'status' => 'success',
			'data' => $accounts,
		], 200);
    }

    public function register($employee_id)
    {
    	$employee = Employee::find($employee_id);
    	return $employee;
    }
}
