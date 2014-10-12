<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PaymentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('payment',function($table){
			$table->increments('id');
			$table->double('payment',10,4);
			$table->integer('bill_id')->unsigned();
			$table->integer('cashier_id')->unsigned();
			//status - for audit_trail purposes
			$table->integer('status');
			$table->double('change', 10, 4);
			$table->timestamps();
			$table->foreign('cashier_id')->references('id')->on('users');
			$table->foreign('bill_id')->references('id')->on('bills');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
