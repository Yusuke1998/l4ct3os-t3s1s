<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Cow\Cow;
use App\Models\Vaccine\Vaccine;
use App\Models\Medicine\Medicine;
use App\Models\Employee\Employee;

class VaccineTableSeeder extends Seeder
{
    public function run()
    {
    	for ($i=0; $i <= 5; $i++) { 
	        Vaccine::create([
	        	'employee_id'	=> Employee::all()->random()->id,
				'medicine_id'	=> Medicine::all()->random()->id,
				'date'			=> Carbon::now()->format('Y-m-d'),
				'quantity'		=> rand(100,500),
				'cow_id' 		=> Cow::all()->random()->id
	        ]);
    	}
    }
}
