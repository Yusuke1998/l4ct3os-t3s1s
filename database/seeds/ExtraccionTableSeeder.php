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
    	for ($i=1; $i <= 15; $i++) { 
	        Extraction::create([
	        	'employee_id'	=> Employee::where('position','extraccion')
	        						->get()
	        						->random()->id,
				'date'			=> date('Y-m-d'),
				'quantity'		=> rand(100,1000),
				'cow_id' 		=> Cow::all()->random()->id
	        ]);
    	}
    }
}
