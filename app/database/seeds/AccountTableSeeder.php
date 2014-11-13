<?php
use Carbon\Carbon;
class AccountTableSeeder extends Seeder{

	public function run(){
		
		for($index = 14; $index <= 635; ++$index){
			$bill = new Bill;
			$bill->account_id = $index;
			$bill->due_date = Carbon::now()->addDays(9);
			$bill->payment_status = 0;
			$bill->start_date = Carbon::createFromDate("2014", "11", "08");
			$bill->end_date = Carbon::createFromDate("2014", "11", "30");
			//update new account
			$account = Account::find($index);
			$account->previous_reading = 0;
			$account->current_reading = 500;
			$account->save();
			$bill->save();
		}

	}
}