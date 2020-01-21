<?php

namespace App\Models\Payment;

use App\Models\Payment\PaymentRelationship;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
	use PaymentRelationship;

    protected $guarded = [];
}
