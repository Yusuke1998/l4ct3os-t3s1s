<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Cow\Cow;
use App\Models\Employee\Employee;
use App\Models\Extraction\Extraction;

class ExtraccionTableSeeder extends Seeder
{
    public function run()
    {
    	for ($i=0; $i <= 5; $i++) { 
	        Extraction::create([
	        	'employee_id'	=> Employee::all()->random()->id,
				'date'			=> Carbon::now()->format('Y-m-d'),
				'quantity'		=> rand(100,1000),
				'cow_id' 		=> Cow::all()->random()->id
	        ]);
    	}
    }
}
