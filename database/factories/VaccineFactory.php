<?php

use App\Model;
use Faker\Generator as Faker;
use Carbon\Carbon;
use App\Models\Cow\Cow;
use App\Models\Vaccine\Vaccine;
use App\Models\Medicine\Medicine;
use App\Models\Employee\Employee;

$factory->define(Vaccine::class, function (Faker $faker) {
    return [
		'employee_id'	=> Employee::all()->random()->id,
		'medicine_id'	=> Medicine::all()->random()->id,
		'date'			=> $faker->dateTimeBetween('01-01-2019'),
		'quantity'		=> $faker->randomElement([
                                        '100','200',
                                        '300','400',
                                        '500','600',
                                        '700','800',
                                        '900','1000'
                                    ]),
		'cow_id' 		=> Cow::all()->random()->id
    ];
});
