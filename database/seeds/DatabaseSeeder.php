<?php

use App\Models\Cow\Cow;
use App\Models\User\User;
use App\Models\Vaccine\Vaccine;
use App\Models\Account\Account;
use App\Models\Payment\Payment;
use Illuminate\Database\Seeder;
use App\Models\Employee\Employee;
use App\Models\Medicine\Medicine;
use App\Models\Extraction\Extraction;

class DatabaseSeeder extends Seeder {

	public function run() {
		$this->call(UsersTableSeeder::class);
        factory(Employee::class,20)->create();
        factory(Account::class,20)->create();
        factory(Payment::class,40)->create();
        factory(Cow::class,100)->create();
        factory(Medicine::class,10)->create();
        factory(Vaccine::class,35)->create();
        factory(Extraction::class,105)->create();
		$this->call(VaccineTableSeeder::class);
		$this->call(ExtraccionTableSeeder::class);
	}
}
