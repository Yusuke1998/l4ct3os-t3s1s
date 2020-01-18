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
		factory(User::class,20)->create();
        factory(Cow::class,20)->create();
        factory(Medicine::class,20)->create();
        factory(Employee::class,20)->create();
        factory(Vaccine::class,20)->create();
        factory(Extraction::class,20)->create();
	}
}
