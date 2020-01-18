<?php

use App\Model;
use Carbon\Carbon;
use App\Models\Cow\Cow;
use Faker\Generator as Faker;

$factory->define(Cow::class, function (Faker $faker) {
    return [
        'type'		 => $faker->randomElement(['girolando', 'holstein', 'brahman', 'pardo_suizo']),
		'weight'	 => $faker->numberBetween(500,1000),
		'year_birth' => Carbon::now()->format('Y'),
		'code'		 => Str::random(5),
		'milking'	 => 1
    ];
});
