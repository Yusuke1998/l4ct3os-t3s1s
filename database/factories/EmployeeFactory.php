<?php

use App\Model;
use Carbon\Carbon;
use Faker\Generator as Faker;
use App\Models\Employee\Employee;

$factory->define(Employee::class, function (Faker $faker) {
    return [
		'name'					=>	$faker->name,
		'identificacion_number'	=>	$faker->numberBetween(1000000,9000000),
		'date_birth' 			=>	$faker->dateTimeBetween('1980-01-01','2000-01-01'),
		'position'				=>	$faker->randomElement([
                                        'worker','extraccion',
                                        'vaccination','supplies'
                                    ]),
    ];
});
