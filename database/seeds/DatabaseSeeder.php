<?php

use App\Models\Cow\Cow;
use App\Models\User\User;
use App\Models\Vaccine\Vaccine;
use Illuminate\Database\Seeder;
use App\Models\Employee\Employee;
use App\Models\Medicine\Medicine;
use App\Models\Extraction\Extraction;

class DatabaseSeeder extends Seeder {

	public function run() {
		$this->call(UsersTableSeeder::class);
		factory(User::class,4)->create();
        factory(Cow::class,100)->create();
        factory(Medicine::class,10)->create();
        factory(Employee::class,30)->create();
		$this->call(VaccineTableSeeder::class);
		$this->call(ExtraccionTableSeeder::class);
        factory(Vaccine::class,50)->create();
        factory(Extraction::class,105)->create();
	}
}
