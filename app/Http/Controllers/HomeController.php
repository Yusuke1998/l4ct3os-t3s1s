<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\Payment\Payment;
use Illuminate\Http\Request;

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
    	$data = $id>0?$model->findOrFail($id):$model->all();

    	$pdf = PDF::loadView('reports.pdfs', $data);
		return $pdf->download($file_name.'.pdf');
    }
}
