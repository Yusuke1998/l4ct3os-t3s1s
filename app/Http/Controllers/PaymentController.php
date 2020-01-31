<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentStoreRequest;
use App\Models\Payment\Payment;
use App\Models\Employee\Employee;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index($status) {
        $query = Payment::where('status','=',$status);
        $payments = $query->get();
        $payments->load('employee','account');
        return response([
            'status' => 'success',
            'data' => $payments,
        ], 200);
    }

    public function datatable(Request $request, $perPage=5)
    {
        $order = isset($request->sort['order'])?$request->sort['order']:'desc';
        $fieldname = isset($request->sort['fieldName'])?$request->sort['fieldName']:'created_at';
        $filter = '%'.$request->filter.'%';

        $payments = Payment::with('employee','account','user')
            ->where('date','LIKE',$filter)
            ->orWhere('code','LIKE',$filter)
            ->orWhere('method','LIKE',$filter)
            ->orWhere('amount','LIKE',$filter)
            ->orWhere('status','LIKE',$filter)
            ->orWhere('description','LIKE',$filter)
            ->orWhereHas('employee',function($query) use ($filter){
                return $query
                    ->where('name','LIKE',$filter)
                    ->orWhere('identificacion_number','LIKE',$filter);
            })
            ->orWhereHas('account',function($query) use ($filter){
                return $query
                    ->where('name_bank','LIKE',$filter)
                    ->orWhere('number','LIKE',$filter);
            })
            ->orWhereHas('user',function($query) use ($filter){
                return $query
                    ->where('name','LIKE',$filter)
                    ->orWhere('email','LIKE',$filter);
            })
            ->orderBy($fieldname,$order)
            ->paginate($perPage);

        return response([
            'pagination' => [
                'totalPages'  => ceil($payments->total()/$perPage),
                'currentPage' => $payments->currentPage(),
            ],
            'data' => $payments->all()
        ], 200);
    }

    public function employee(Request $request, $employee_id, $perPage=5)
    {
        $order = isset($request->sort['order'])?$request->sort['order']:'desc';
        $fieldname = isset($request->sort['fieldName'])?$request->sort['fieldName']:'created_at';
        $filter = '%'.$request->filter.'%';

        $payments = Payment::with('employee','account')
            ->where('employee_id','=',$employee_id)
            ->where('status','=','realizado')
            ->orderBy($fieldname,$order)
            ->paginate($perPage);

        return response([
            'pagination' => [
                'totalPages'  => ceil($payments->total()/$perPage),
                'currentPage' => $payments->currentPage(),
            ],
            'data' => $payments->all()
        ], 200);
    }

    public function register(PaymentStoreRequest $request)
    {
        $payment = new Payment();
        $payment->code          =   'COD'.rand(10000,99999);
        $payment->amount        =   $request->amount;
        $payment->description   =   !isset($request->description)?'n/a':$request->description;
        $payment->employee_id   =   $request->employee_id;
        $payment->user_id       =   \Auth::User()->id;
        if ($request->method === 'transferencia')
        {
            $payment->account_id = $request->account_id;
        }
        $payment->save();
        return response([
            'status' => 'success',
            'data' => $payment,
        ], 200);
    }

    public function update(PaymentStoreRequest $request, Payment $payment){
        $payment->update($request->all());
        return response([
            'status' => 'success',
            'data' => $payment,
        ], 200);
    }

    public function status(PaymentStoreRequest $request, Payment $payment){
        $payment->status = 'realizado';
        $payment->save();
        return response([
            'status' => 'success',
            'data' => $payment,
        ], 200);
    }

    public function delete(Payment $payment) {
        $payment->delete();
        return response([
            'status' => 'success',
            'data' => $payment,
        ], 200);
    }
}
