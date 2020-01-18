<?php

use App\Model;
use Carbon\Carbon;
use Faker\Generator as Faker;
use App\Models\Medicine\Medicine;

$factory->define(Medicine::class, function (Faker $faker) {
    return [
		'name_medicine'	=> $faker->word(5),
		'date' 			=> Carbon::now()->format('Y-m-d')
    ];
});
