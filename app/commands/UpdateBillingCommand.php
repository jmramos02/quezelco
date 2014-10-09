<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Carbon\Carbon;

class UpdateBillingCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'update:billing';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Update billing status.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{

		$accounts = Account::all();
		$count = Account::all()->count();
		if($count != 0){
			foreach($accounts as $account){
				$bill = Bill::where('account_id', '=', $account->id)->where('payment_status', '=' , 0)->orderBy('id','desc')->first();
				if(!is_null($bill)){
					$carbonDate = Carbon::parse($bill->due_date);
					$dateDiff = $carbonDate->diffInDays(Carbon::now());
					$this->info($dateDiff);
					if($dateDiff <= 9){
						$bill->payment_status = 2;
					}else if($dateDiff >= 10){
						$bill->payment_status = 3;
						$account->status = 0;
					}
					$bill->save();
					$account->save();
				}

			}
		}
		exit;

	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		
		return array(
			
		);
	}

}
