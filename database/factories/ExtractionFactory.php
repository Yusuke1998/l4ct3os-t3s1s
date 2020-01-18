<?php

use App\Model;
use Carbon\Carbon;
use Faker\Generator as Faker;
use App\Models\Cow\Cow;
use App\Models\Employee\Employee;
use App\Models\Extraction\Extraction;

$factory->define(Extraction::class, function (Faker $faker) {
    return [
        'employee_id'	=> Employee::all()->random()->id,
		'date'			=> $faker->dateTimeBetween('01-01-2019',Date('Y-m-d')),
		'quantity'		=> $faker->numberBetween(100,1000),
		'cow_id' 		=> Cow::all()->random()->id
    ];
});
