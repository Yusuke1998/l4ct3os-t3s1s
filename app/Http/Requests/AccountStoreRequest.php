<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = get_model_id($this, 'account');

        if ($id) {
            return [
                'name_bank' => 'required|string',
            ];

        } else {
            return [
                'name_bank' => 'required|string',
            ];

        }
    }
}
