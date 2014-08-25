<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WheelingRatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wheeling_rates',function($table){
			$table->increments('id');
			$table->double('generation_system_charge',10,3);
			$table->double('transmission_system_charge',10,3);
			$table->double('system_loss_charge',10,3);
			$table->double('dist_system_charge',10,3);
			$table->double('retail_end_user_charge',10,3);
			$table->double('retail_customer_charge',10,3);
			$table->double('lifeline_subsidy',10,3);
			$table->double('prev_yrs_adj_pwr_cost',10,3);
			$table->double('contribution_for_capex',10,3);
			$table->double('generation_vat',10,3);
			$table->double('transmission_vat',10,3);
			$table->double('system_loss_vat',10,3);
			$table->double('distribution_vat',10,3);
			$table->double('others',10,3);
			$table->double('missionary_electrificxn',10,3);
			$table->double('environmental_charge',10,3);
			$table->double('npc_stranded_cont_cost',10,3);
			$table->double('sr_citizen_subsidy',10,3);
			$table->timeStamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('wheeling_rates');
	}

}
