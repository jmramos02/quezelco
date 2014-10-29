<?php
use Quezelco\Interfaces\BillRepository as Bill;
use Quezelco\Interfaces\AuthRepository as Auth;
use Quezelco\Interfaces\RatesRepository as Rate;
use Quezelco\Interfaces\AccountRepository as Account;
use Symfony\Component\Intl\NumberFormatter\NumberFormatter;

class CollectorController extends BaseController{
	public function __construct(Bill $bill, Auth $auth, Rate $rate, Account $account){
		$this->auth = $auth;
		$this->bill = $bill;
		$this->rate = $rate;
		$this->account = $account;
	}
	public function showHome(){
		return View::make('collector.index');
	}

	public function showOEBR(){

		$rules = array('oebr' => 'required|exists:accounts,oebr_number');
		$validator = Validator::make(Input::all(),$rules);
		if($validator->fails()){
			return Redirect::to('collector/home')->withErrors($validator);
		}else{
			$oebr = Input::get('oebr');
			$bill = $this->bill->findNextPayment($oebr);
			if(is_null($bill)){
				Session::flash('message','There are no pending dues for this account');
				return Redirect::to('collector/home');
			}
			$account = $this->account->findByOebr(Input::get('oebr'));
			$consumed = $account->current_reading - $account->previous_reading;
			$rates = $this->rate->getRates();

			$senior_discount = 0;
			if(Input::get('is_senior') == 'on')
			{
				$senior_discount = $rates->sr_citizen_subsidy;
			}

			$sum = 0;
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
			if($bill->payment_status == 2){
				$penalty = $sum * 0.12;
				$sum += $penalty;
			}else if($bill->status == 3){
				$penalty = $sum * 0.12;
				$sum += $penalty;
				$sum += 112;
			}
			$sum -= $sum * $senior_discount;
			return View::make('collector.payment')->with('bill',$bill)->with('payment',$sum)->with('oebr',$oebr);
		}
		
	}

	public function acceptPayment($id){
		$formattedValue = intval(str_replace(',', '', Input::get('due_payment')));
		$rules = array('payment' => 'required');
		$oebr = Input::get('oebr');
		$validator = Validator::make(Input::all(),$rules);

		if($validator->fails()){
			return Redirect::to('cashier/payment/search-oebr?oebr=' . $oebr)->withErrors($validator);
		}else{
			if($formattedValue > Input::get('payment')){
				Session::flash('error_message','Invalid Amount');
				return Redirect::to('cashier/payment/search-oebr?oebr=' . $oebr)->withErrors($validator);
			}
			$bill = $this->bill->find($id);
			$bill->payment_status = 1;
			$bill->save();
			$payment = new Payment();
			$payment->payment = Input::get('payment');
			$payment->change = Input::get('payment') - $formattedValue;
			$payment->bill_id = $id;
			$payment->cashier_id = $this->auth->getCurrentUser()->id;
			$payment->status = $bill->payment_status;

			$payment->save();
			Session::flash('message','Payment Accepted! Change is: ' . $payment->change);
			return Redirect::to('collector/home');
		}
	}

	public function showMyAccount(){
		return View::make('collector.my-account');
	}

	public function updatePassword()
	{
		$rules = array('current_password' =>'required',
				'new_password' => 'required',
				'repeat_new_password' => "same:new_password");

		$validator = Validator::make(Input::all(), $rules);
		if( $validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$user = $this->auth->getCurrentUser();

		print_r($user->password . '<br/><br/>');

		if (!Hash::check(Input::get('current_password'), $user->password))
		{
		    return Redirect::back();
		}

		$user->password = Input::get('new_password');
		$user->save();

		return Redirect::to('collector/home');
	}
}