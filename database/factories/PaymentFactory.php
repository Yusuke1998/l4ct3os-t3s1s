<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Carbon\Carbon;
use App\Models\User\User;
use App\Models\Payment\Payment;
use App\Models\Employee\Employee;

use Faker\Generator as Faker;

$factory->define(Payment::class, function (Faker $faker) {
	$trabajador = Employee::whereHas('accounts')
							->get()
							->random();
    return [
        'date'          => $faker->dateTimeBetween('2019-01-01',date('Y-m-d')),
        'code'			=> rand(9001,1001),
        'status'		=> $faker->randomElement(['pendiente','realizado']),
        'amount'		=> rand(1000,9000),
        'description'	=> 'n/a',
        'user_id'		=> User::all()
        						->random()->id,
        'employee_id'	=> $trabajador->id,
        'account_id'	=> $trabajador
        						->accounts()
        						->first()->id
    ];
});
