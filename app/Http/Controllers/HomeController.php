<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Payment\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('reports');
    }

    public function index()
    {
        return view('home');
    }

    public function paymentReports($item='')
    {   
    	$pagos = DB::table('payments')
    				->join('accounts', 'payments.account_id', '=', 'accounts.id')
            		->join('employees', 'payments.employee_id', '=', 'employees.id')
                    ->select(DB::raw('code AS codigo, date AS fecha, CAST(amount as decimal(16,2)) as monto, status AS estado, employees.name as trabajador, accounts.number as cuenta, accounts.name_bank as banco'));
        switch ($item) {
			case 'day':
				$data = $pagos
				->where('date',date('Y-m-d'))
				->get();
				break;
			case 'week':
				$data = $pagos->whereBetween('date',
            			[
            				Carbon::now()->startOfWeek(),
            				Carbon::now()->endOfWeek()
            			])->get();
				break;
			case 'month':
				$data = $pagos->whereBetween('date',
            			[
            				Carbon::now()->startOfMonth(),
            				Carbon::now()->endOfMonth()
            			])->get();
				break;
			case 'year':
				$data = $pagos->whereBetween('date',
            			[
            				Carbon::now()->startOfYear(),
            				Carbon::now()->endOfYear()
            			])->get();
				break;
			default:
				$data = $pagos->get();
				break;
		}

    	return response([
			'status'    => 'success',
			'data'      => $data,
		], 200);
    }
}
