<?php
namespace Quezelco\Eloquent;

use Quezelco\Interfaces\BillRepository;
use Bill;
use Carbon\Carbon;
use Fpdf;
use WheelingRates;
use Account;

class EloquentBillRepository implements BillRepository{
	private $recordsPerPage = 10;


	
	public function find($id){
		return Bill::find($id);
	}

	public function updateBilling($account, $inputs){
		//save new bill
		$arrayStart = explode("/",$inputs['start_date']);
		$arrayEnd =  explode("/", $inputs['end_date']);
		$bill = new Bill();
		$bill->account_id = $account->id;
		$bill->due_date = Carbon::now()->addDays(9);
		$bill->payment_status = 0;
		$bill->start_date = Carbon::createFromDate($arrayStart[2], $arrayStart[0], $arrayStart[1]);
		$bill->end_date = Carbon::createFromDate($arrayEnd[2], $arrayEnd[0], $arrayEnd[1]);
		
		//update new account
		$current = $account->current_reading;
		$account->previous_reading = $current;
		$account->current_reading = $inputs['new_reading'];
		$account->save();
		//compute for total payment
		$rates = WheelingRates::find(1);
		
		$consumed = $account->current_reading - $account->previous_reading;

		/*$sum = 0;
		$sum += $rates->generation_system_charge * $consumed;	
		$sum += $rates->transmission_system_charge * $consumed;
		$sum += $rates->system_loss_charge * $consumed;
		$sum += $rates->dist_system_charge * $consumed;
		$sum += $rates->retail_end_user_charge;
		$sum += $rates->retail_customer_charge;
		$sum += $rates->lifeline_subsidy * $consumed;
		$sum += $rates->prev_yrs_adj_pwr_cost * $consumed;
		$sum += $rates->contribution_for_capex * $consumed;
		$sum += $rates->generation_vat * $consumed;
		$sum += $rates->transmission_vat * $consumed;
		$sum += $rates->system_loss_vat * $consumed;
		$sum += $rates->distribution_vat;
		$sum += $rates->others * $consumed;
		$sum += $rates->missionary_electrificxn * $consumed;
		$sum += $rates->environmental_charge * $consumed;
		$sum += $rates->npc_stranded_cont_cost * $consumed;
		$penalty = $sum * 0.12;
		$sum = $sum + $penalty;
		$sum += 112;



		$bill->total_payment = $sum;*/

		$bill->save();


	}

	public function update($bill, $account, $inputs)
	{
		$arrayStart = explode("-",$inputs['start_date']);
		$arrayEnd =  explode("-", $inputs['end_date']);

		$bill->account_id = $account->id;
		$bill->due_date = Carbon::now()->addDays(9);
		$bill->payment_status = 0;
		$bill->start_date = date("Y-m-d", strtotime($inputs['start_date']));
		$bill->end_date = date("Y-m-d", strtotime($inputs['end_date']));
		
		//update new account
		$account->current_reading = $inputs['current_reading'];
		$account->save();
		//compute for total payment
		$rates = WheelingRates::find(1);
		$bill->save();
	}

	public function all(){
		return Bill::all();
	}

	public function paginate(){
		return Bill::select('bills.id as id', 'account_number', 'oebr_number', 'first_name', 'last_name', 'due_date', 'payment_status')
				   ->paginate($this->recordsPerPage);
	}

	public function findNextPayment($oebr_number){
		$account = Account::where('oebr_number', '=', $oebr_number)->first();
		return $bill = Bill::where('account_id', '=', $account->id)->where('payment_status', '=' , 0)->orderBy('id','desc')->first();
	}

	public function search($search_key)
	{
		$query = "%$search_key%";

		$bills = Bill::join('accounts', 'bills.account_id', '=', 'accounts.id')
					 ->join('users', 'accounts.user_id', '=', 'users.id')
					 ->join('routes', 'accounts.route_id', '=', 'routes.id')
					 ->whereRaw('oebr_number LIKE ? OR route_name LIKE ?', array($query, $query))
					 ->select('bills.id as id','accounts.id as account_id', 'account_number', 'oebr_number', 'first_name', 'last_name', 'due_date')
					 ->paginate($this->recordsPerPage);

		return $bills;
	}

	public function findNextPaymentById($id){
		$account = Account::find($id);
		return $bill = Bill::where('account_id', '=', $account->id)->where('payment_status', '=' , 0)->orderBy('id','desc')->first();
	}

}