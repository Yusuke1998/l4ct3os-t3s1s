<?php

namespace App\Http\Controllers;

use App\Models\Payment\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index($status=null) {

        if ($status=='realizado')
        {
            $payments = Payment::all();
        } elseif ($status=='pendiente') 
        {
            $payments = Payment::all();
        }
        return response([
            'status' => 'success',
            'data' => $payments,
        ], 200);
    }

    public function ref($ref)
    {
        //
    }

    public function register(Request $request) {

        $payment = new Payment();
        $payment->create($request->except('_token'));

        return response([
            'status' => 'success',
            'data' => $payment,
        ], 200);

    }

    public function update(Request $request, Payment $payment) {
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
