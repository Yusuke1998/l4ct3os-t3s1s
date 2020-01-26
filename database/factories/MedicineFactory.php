<?php

use App\Model;
use Carbon\Carbon;
use Faker\Generator as Faker;
use App\Models\Medicine\Medicine;

$factory->define(Medicine::class, function (Faker $faker) {
    return [
		'name_medicine'	=> $faker->word(5),
		'date' 			=> $faker->dateTimeBetween('2018-01-01','2030-01-01'),
		'quantity'		=> $faker->randomElement([
                                        '100','200',
                                        '300','400',
                                        '500','600',
                                        '700','800',
                                        '900','1000'
                                    ]),
    ];
});
