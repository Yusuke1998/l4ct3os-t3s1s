<?php

use App\Model;
use Carbon\Carbon;
use Faker\Generator as Faker;
use App\Models\Employee\Employee;

$factory->define(Employee::class, function (Faker $faker) {
    return [
		'name'					=>	$faker->name,
		'identificacion_number'	=>	$faker->numberBetween(1000000,9000000),
		'date_birth' 			=>	Carbon::now()->format('Y-m-d'),
		'position'				=>	$faker->randomElement([
                                        'worker','extraccion',
                                        'vaccination','supplies'
                                    ]),
    ];
});
