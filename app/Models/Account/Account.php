<?php

namespace App\Models\Account;

use App\Models\Account\AccountScope;
use App\Models\Account\AccountRelationship;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use AccountRelationship,
    	AccountScope;
    protected $guarded = [];
}
