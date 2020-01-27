<?php

namespace App\Http\Controllers;
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

    public function reports($model,$time=0,$id=0)
    {
    	$file_name = $model.'-'.time();
    	$model = ucfirst($model);
        $model = app("App\Models\\$model\\$model");
        
        if($id>0){
            $data = $model->findOrFail($id);
        }else{
            $data = [
                'day'   =>  $model::where('date',date('Y-m-d'))->get(),
                'week'  =>  $model::whereBetween('date',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])->get(),
                'month' =>  $model::whereBetween('date',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()])->get(),
                'year'  =>  $model::whereBetween('date',[Carbon::now()->startOfYear(),Carbon::now()->endOfYear()])->get(),
            ];
        }

    	return response([
			'status'    => 'success',
			'data'      => $data,
		], 200);
    }
}
