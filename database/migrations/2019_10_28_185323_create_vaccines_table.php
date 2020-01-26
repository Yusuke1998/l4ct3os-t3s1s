<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVaccinesTable extends Migration {

	public function up() {
		Schema::create('vaccines', function (Blueprint $table) {
			$table->bigIncrements('id');

			$table->bigInteger('employee_id')->unsigned();
			$table->foreign('employee_id')
				->references('id')
				->on('employees')
				->onUpdate('cascade')
				->onDelete('cascade');

			$table->bigInteger('cow_id')->unsigned();
			$table->foreign('cow_id')
				->references('id')
				->on('cows')
				->onUpdate('cascade')
				->onDelete('cascade');

			$table->bigInteger('medicine_id')->unsigned();
			$table->foreign('medicine_id')
				->references('id')
				->on('medicines')
				->onUpdate('cascade')
				->onDelete('cascade');

			$table->date('date');
			$table->float('quantity');

			$table->timestamps();
		});
	}

	public function down() {
		Schema::dropIfExists('vaccines');
	}
}
