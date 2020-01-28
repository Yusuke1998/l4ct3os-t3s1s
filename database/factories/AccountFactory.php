<?php

use App\Model;
use App\Models\Account\Account;
use App\Models\Employee\Employee;
use Faker\Generator as Faker;

$factory->define(Account::class, function (Faker $faker) {
    return [
        'name_bank' 	=> $faker->randomElement(['Venezuela', 'Banesco', 'Bicentenario', 'Mercantil', 'Provincial']),
        'number'		=> '1000000000000'.$faker->numberBetween(100000,900000),
        'employee_id'	=> Employee::all()->random()->id
    ];
});
