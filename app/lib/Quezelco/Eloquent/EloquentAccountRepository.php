<?php
namespace Quezelco\Eloquent;

use Quezelco\Interfaces\AccountRepository;
use Account;
use User;

class EloquentAccountRepository implements AccountRepository{

	private $recordsPerPage = 15;

	public function search($searchKey){
		$query = "%$searchKey%";	
		return Account::whereRaw('account_number LIKE ? or meter_number LIKE ? or billing_address LIKE ?',
				 array($query,$query,$query))->paginate($this->recordsPerPage);
	}

	public function addAccountToConsumer($user, $inputs){
		$account = new Account();
		$account->user_id = $user->id;
		$account->oebr_number = $inputs['oebr_number'];
		$account->account_number = $inputs['account_number'];
		$account->route_id = $inputs['route_id'];
		$account->meter_number = $inputs['meter_number'];
		$account->billing_address = $inputs['billing_address'];
		$account->current_reading = 0;
		$account->previous_reading = 0;
		$account->status = 1;
		$account->save();
	}

	public function updateAccount($account, $inputs){
		$account->meter_number = $inputs['meter_number'];
		$account->route_id = $inputs['route_id'];
		$account->billing_address = $inputs['billing_address'];
		$account->save();
	}

	public function updateReading($consumer, $newReading){
		$previousReading = $consumer->current_reading;
		$consumer->current_reading = $newReading;
		$consumer->previous_reading = $previousReading;
		$consumer->save();
	}

	public function changeStatus($account){
		if($account->status == 0){
			$account->status = 1;
		}else{
			$account->status = 0;
		}
		$account->save();
	}

	public function all(){
		return Account::all();
	}


	public function find($id){
		return Account::find($id);
	}

	public function paginate(){
		return Account::paginate($this->recordsPerPage);
	}

	public function findAccountsByUser($user){
		return Account::where('user_id','=',$user->id);
	}

	public function findByOebr($oebr){
		return Account::where('oebr_number', '=', $oebr)->first();
	}
}