<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BillTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bills',function($table){
			$table->increments('id');
			$table->integer('account_id')->unsigned();
			$table->date('due_date');
			$table->tinyInteger('payment_status');
			/*$table->decimal('total_payment', 10, 4);*/
			$table->date('start_date');
			$table->date('end_date');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('bills');
	}

}
