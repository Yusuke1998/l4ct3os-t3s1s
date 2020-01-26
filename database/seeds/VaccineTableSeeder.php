<?php

use Illuminate\Database\Seeder;
use App\Models\Cow\Cow;
use App\Models\Vaccine\Vaccine;
use App\Models\Medicine\Medicine;
use App\Models\Employee\Employee;

class VaccineTableSeeder extends Seeder{
    public function run()
    {
    	for ($i=1; $i <= 7; $i++) { 
	        Vaccine::create([
	        	'employee_id'	=> Employee::where('position','vaccination')
				                            ->get()
				                            ->random()->id,
				'medicine_id'	=> Medicine::where('date','>',date('Y-m-d'))
				                            ->get()
				                            ->random()->id,
				'date'			=> date('Y-m-d'),
				'quantity'		=> rand(100,500),
				'cow_id' 		=> Cow::all()->random()->id
	        ]);
    	}
    }
}
