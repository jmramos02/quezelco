<?php

class AccountTableSeeder extends Seeder{

	public function run(){
		$account = new Account();
		$account->account_number = '12-8924-5434';
		$account->meter_number = '65391543';
		$account->oebr_number = '2014D700054444';
		$account->user_id = 6;
		$account->route_id = 16;
		$account->billing_address = 'PyongYang';
		$account->current_reading = 0;
		$account->previous_reading = 0;
		$account->senior = false;
		$account->status = 1;

		$account->save();

		$account = new Account();
		$account->account_number = '15-5424-9053';
		$account->meter_number = '91242505';
		$account->oebr_number = '2014G978018082';
		$account->user_id = 7;
		$account->route_id = 16;
		$account->billing_address = 'Jeje Island';
		$account->current_reading = 0;
		$account->previous_reading = 0;
		$account->senior = false;
		$account->status = 1;

		$account->save();
	}
}