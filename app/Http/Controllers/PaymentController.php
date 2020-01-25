<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentStoreRequest;
use App\Models\Payment\Payment;
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

    public function ref($ref)
    {
        //
    }

    public function register(PaymentStoreRequest $request)
    {
        $payment = new Payment();
        $payment->code='COD'.rand(10000,99999);
        $payment->amount        = $request->amount;
        $payment->description   = $request->description;
        $payment->employee_id   = $request->employee_id;
        $payment->account_id    = $request->account_id;
        $payment->user_id=\Auth::User()->id;
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

    public function delete(Payment $payment) {
        $payment->delete();
        return response([
            'status' => 'success',
            'data' => $payment,
        ], 200);
    }
}
