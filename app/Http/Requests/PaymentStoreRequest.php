<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentStoreRequest extends FormRequest
{
    public function authorize() {
        return true;
    }
    
    public function rules() {

        $id = get_model_id($this, 'payment');

        if ($id) {
            return [
                'amount'        => 'required',
                'employee_id'   => 'required',
            ];

        } else {
            return [
                'amount'        => 'required',
                'employee_id'   => 'required',
            ];

        }
    }

    public function messages() {

        return [
            'amount.required'       => 'El monto es obligatorio',
            'employee_id.required'  => 'El trabajador es obligatorio',
        ];
    }
}
