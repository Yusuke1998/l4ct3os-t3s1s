<?php

use App\Model;
use Carbon\Carbon;
use Faker\Generator as Faker;
use App\Models\Cow\Cow;
use App\Models\Employee\Employee;
use App\Models\Extraction\Extraction;

$factory->define(Extraction::class, function (Faker $faker) {
    return [
        'employee_id'	=> Employee::where('position','extraccion')
        							->get()
        							->random()->id,
		'date'			=> $faker->dateTimeBetween('2015-01-01'),
		'quantity'		=> $faker->numberBetween(100,1000),
		'cow_id' 		=> Cow::all()->random()->id
    ];
});
