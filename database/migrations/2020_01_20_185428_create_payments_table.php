<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->unique();
            $table->float('amount');
            $table->date('date')->default(date('Y-m-d'));
            $table->enum('status',
                ['realizado','pendiente']
            )->default('pendiente');
            $table->text('description')->nullable();
            
            $table->bigInteger('employee_id')->unsigned();
            $table->foreign('employee_id')
                    ->references('id')
                    ->on('employees')
                    ->onDelete('cascade');

            $table->bigInteger('account_id')->unsigned();
            $table->foreign('account_id')
                    ->references('id')
                    ->on('accounts')
                    ->onDelete('cascade');
                    
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
