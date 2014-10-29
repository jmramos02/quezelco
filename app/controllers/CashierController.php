<?php

use Quezelco\Interfaces\BillRepository as Bill;
use Quezelco\Interfaces\AuthRepository as Auth;
use Quezelco\Interfaces\RatesRepository as Rate;
use Quezelco\Interfaces\AccountRepository as Account;
use Symfony\Component\Intl\NumberFormatter\NumberFormatter;
use Carbon\Carbon as Carbon;
class CashierController extends BaseController{
	public function __construct(Bill $bill, Auth $auth, Rate $rate, Account $account){
		$this->auth = $auth;
		$this->bill = $bill;
		$this->rate = $rate;
		$this->account = $account;
	}
	public function showHome(){
		return View::make('cashier.index');
	}

	public function showOEBR(){
		$rules = array('oebr' => 'required|exists:accounts,oebr_number');
		$validator = Validator::make(Input::all(),$rules);
		if($validator->fails()){
			return Redirect::to('cashier/home')->withErrors($validator);
		}else{
			$oebr = Input::get('oebr');
			$bill = $this->bill->findNextPayment($oebr);
			if(is_null($bill)){
				Session::flash('message','There are no pending dues for this account');
				return Redirect::to('cashier/home');
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
				$penalty = $sum * $rates->penalty;
				$sum += $penalty;
			}else if($bill->status == 3){
				$penalty = $sum * $rates->penalty;
				$sum += $penalty;
				$sum += $rates->reconnection_fee;
			}
			$sum -= $sum * $senior_discount;
			return View::make('cashier.payment')->with('bill',$bill)->with('payment',$sum)->with('oebr',$oebr);
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
			$payment = new Payment();
			$payment->payment = Input::get('payment');
			$payment->change = Input::get('payment') - $formattedValue;
			$payment->bill_id = $id;
			$payment->cashier_id = $this->auth->getCurrentUser()->id;
			$payment->status = $bill->payment_status;
			$payment->save();
			$bill->payment_status = 1;
			$bill->save();
			Session::flash('message','Payment Accepted! Change is: ' . $payment->change);
			return Redirect::to('cashier/home');
		}
		
	}

	public function showMyAccount(){
		return View::make('cashier.my-account');
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

		return Redirect::to('cashier/home');
	}

	public function reprint(){
		return View::make('cashier.reprint');
	}
	public function printing(){
		$rules = array('oebr' => 'required|exists:accounts,oebr_number');
		$validator = Validator::make(Input::all(),$rules);
		if($validator->fails()){
			return Redirect::to('cashier/reprint')->withErrors($validator);
		}
		$bill = $this->bill->findNextPayment(Input::get('oebr'));
		if(is_null($bill)){
			Session::flash('message','There are no pending dues for this account');
			return Redirect::to('cashier/home');
		}
		$rates = $this->rate->getRates();
		$accountObject = $bill->account()->first();
		$userObject = $bill->account()->first()->consumer()->first();

		$last_name = $userObject->last_name;
		$first_name = $userObject->first_name;
		$account_number = $accountObject->account_number;
		$consumed = ($accountObject->current_reading - $accountObject->previous_reading);	
		$periodCovered = $bill->start_date . ' to '. $bill->end_date;


		$sum = 0;

		Fpdf::AddPage();
        Fpdf::SetFont('Courier','B',16);
        Fpdf::Cell(190,10,'Quezelco Electronic Cooperative',0,1,'C');
        Fpdf::SetFont('Courier','',11);
        Fpdf::Cell(190,10,'Billing Statement',0,1,'C');
        Fpdf::SetFont('Courier','','9');
        Fpdf::Ln(5);
        Fpdf::Cell(40,0,'--------------------------------------------------------------------------------------------------');
        Fpdf::ln(5);	
        Fpdf::Cell(40,0,"Billing Statement For: " . $first_name . ', ' . $last_name );
        Fpdf::Ln(5);
        Fpdf::Cell(40,0,'Account Number: ' . $account_number );
        Fpdf::Ln(5);
        Fpdf::Cell(40,0,"KWH: Consumed: $consumed"  );
        Fpdf::Ln(5);
        Fpdf::Cell(40,0,"Due Date: $bill->due_date"  );
        Fpdf::Ln(5);
        Fpdf::Cell(40,0,"Period Covered From: $periodCovered");
        Fpdf::Ln(5);
        Fpdf::Cell(40,0,"Previous Reading: " . $accountObject->previous_reading);
        Fpdf::ln(5);
        Fpdf::Cell(40,0,"Current Reading: " . $accountObject->current_reading);
        Fpdf::ln(5);
        Fpdf::Cell(40,0,'--------------------------------------------------------------------------------------------------');
        Fpdf::ln(5);
        Fpdf::Cell(40,0,"Date Printed: " . Carbon::now());
        Fpdf::Ln(5);
        Fpdf::Cell(40,0,'--------------------------------------------------------------------------------------------------');
        Fpdf::Ln(5);
        Fpdf::SetFont('Courier','B',9);
        Fpdf::Cell(70,0,'Charges');
        Fpdf::Cell(70,0,'Rate/KW/KWH');
        Fpdf::Cell(70,0,'Amount');
        Fpdf::SetFont('Courier','','9');
        Fpdf::Ln(5);
        Fpdf::Cell(70,0,'Generation System Charge');
        Fpdf::Cell(70,0, number_format($rates->generation_system_charge,4));
        Fpdf::Cell(70,0, number_format($rates->generation_system_charge * $consumed,4));

        $sum += $rates->generation_system_charge * $consumed;

        Fpdf::ln(5);
        Fpdf::Cell(70,0,'Transmission System Charge');
        Fpdf::Cell(70,0, number_format($rates->transmission_system_charge,4));
        Fpdf::Cell(70,0, number_format($rates->transmission_system_charge * $consumed,4));
        $sum += $rates->transmission_system_charge * $consumed;

        Fpdf::ln(5);
        Fpdf::Cell(70,0,'System Loss Charge');
        Fpdf::Cell(70,0, number_format($rates->system_loss_charge,4));
        Fpdf::Cell(70,0, number_format($rates->system_loss_charge * $consumed,4));
        $sum += $rates->system_loss_charge * $consumed;

        Fpdf::ln(5);
        Fpdf::Cell(70,0,'Distribution System Charge');
        Fpdf::Cell(70,0, number_format($rates->dist_system_charge,4));
        Fpdf::Cell(70,0, number_format($rates->dist_system_charge * $consumed,4));
        $sum += $rates->dist_system_charge * $consumed;

        Fpdf::ln(5);
        Fpdf::Cell(70,0,'Retail End User Charge');
        Fpdf::Cell(70,0, '');
        Fpdf::Cell(70,0, number_format($rates->retail_end_user_charge,4));
        $sum += $rates->retail_end_user_charge;

        Fpdf::ln(5);
        Fpdf::Cell(70,0,'Retail End User Charge');
        Fpdf::Cell(70,0, '');
        Fpdf::Cell(70,0, number_format($rates->retail_customer_charge,4));
        $sum += $rates->retail_customer_charge;

        Fpdf::ln(5);
        Fpdf::Cell(70,0,'Lifeline Subsidy');
        Fpdf::Cell(70,0, number_format($rates->lifeline_subsidy,4));
        Fpdf::Cell(70,0, number_format($rates->lifeline_subsidy * $consumed,4));
        $sum += $rates->lifeline_subsidy * $consumed;

        Fpdf::ln(5);
        Fpdf::Cell(70,0,'Previous Years Adjust Power Cost');
        Fpdf::Cell(70,0, number_format($rates->prev_yrs_adj_pwr_cost,4));
        Fpdf::Cell(70,0, number_format($rates->prev_yrs_adj_pwr_cost * $consumed,4));
        $sum += $rates->prev_yrs_adj_pwr_cost * $consumed;

        Fpdf::ln(5);
        Fpdf::Cell(70,0,'Contribution for CAPEX');
        Fpdf::Cell(70,0, number_format($rates->contribution_for_capex,4));
        Fpdf::Cell(70,0, number_format($rates->contribution_for_capex * $consumed,4));
        $sum += $rates->contribution_for_capex * $consumed;

        Fpdf::ln(5);
        Fpdf::SetFont('Courier','B',9);
        Fpdf::Cell(40,0,'Value Added Tax-----------------------------------------------------------------------------------');
        Fpdf::SetFont('Courier','',9);
        Fpdf::ln(5);
        Fpdf::Cell(70,0,'Generation');
        Fpdf::Cell(70,0, number_format($rates->generation_vat,4));
        Fpdf::Cell(70,0, number_format($rates->generation_vat * $consumed,4));
        $sum += $rates->generation_vat * $consumed;

        Fpdf::ln(5);
        Fpdf::Cell(70,0,'Transmission');
        Fpdf::Cell(70,0, number_format($rates->transmission_vat,4));
        Fpdf::Cell(70,0, number_format($rates->transmission_vat * $consumed,4));
        $sum += $rates->transmission_vat * $consumed;

        Fpdf::ln(5);
        Fpdf::Cell(70,0,'System Loss');
        Fpdf::Cell(70,0, number_format($rates->system_loss_vat,4));
        Fpdf::Cell(70,0, number_format($rates->system_loss_vat * $consumed,4));
        $sum += $rates->system_loss_vat * $consumed;

        Fpdf::ln(5);
        Fpdf::Cell(70,0,'Distribution');
        Fpdf::Cell(70,0, '');
        Fpdf::Cell(70,0, number_format($rates->distribution_vat,4));
        $sum += $rates->distribution_vat;

        Fpdf::ln(5);
        Fpdf::Cell(70,0,'Others');
        Fpdf::Cell(70,0, number_format($rates->others,4));
        Fpdf::Cell(70,0, number_format($rates->others * $consumed,4));
        $sum += $rates->others * $consumed;
        

        Fpdf::ln(5);
        Fpdf::SetFont('Courier','B',9);
        Fpdf::Cell(40,0,'Universal Charges--------------------------------------------------------------------------------');
        Fpdf::SetFont('Courier','',9);

        Fpdf::ln(5);
        Fpdf::Cell(70,0,'Missionary Electrificxn');
        Fpdf::Cell(70,0, number_format($rates->missionary_electrificxn,4));
        Fpdf::Cell(70,0, number_format($rates->missionary_electrificxn * $consumed,4));
        $sum += $rates->missionary_electrificxn * $consumed;

        Fpdf::ln(5);
        Fpdf::Cell(70,0,'Environmental Charge');
        Fpdf::Cell(70,0, number_format($rates->environmental_charge,4));
        Fpdf::Cell(70,0, number_format($rates->environmental_charge * $consumed,4));
        $sum += $rates->environmental_charge * $consumed;

        Fpdf::ln(5);
        Fpdf::Cell(70,0,'NPC Stranded Cont Cost');
        Fpdf::Cell(70,0, number_format($rates->npc_stranded_cont_cost,4));
        Fpdf::Cell(70,0, number_format($rates->npc_stranded_cont_cost * $consumed,4));
        $sum += $rates->npc_stranded_cont_cost * $consumed;
        Fpdf::ln(5);

        Fpdf::ln(5);
        Fpdf::Cell(40,0,'--------------------------------------------------------------------------------------------------');
        Fpdf::ln(5);
        Fpdf::SetFont('Courier','B',13);
        Fpdf::Cell(70,0,'Total Amount Due before Charges');
        Fpdf::Cell(70,0, '');
        Fpdf::Cell(70,0,number_format($sum,2));
        Fpdf::ln(5);
        Fpdf::SetFont('Courier','',9);
	$penalty = $sum * $rates->penalty;
        $penaltyVat = $penalty * $rates->penalty;
	$sum = $sum + $penalty;
	$penalty = $penalty - $penaltyVat;
        Fpdf::ln(5);
        Fpdf::Cell(40,0,'Penalties-----------------------------------------------------------------------------------------');
        Fpdf::ln(5);
        Fpdf::SetFont('Courier','',9);
        Fpdf::ln(5);
        Fpdf::Cell(70,0,'Penalty');
	Fpdf::Cell(70,0, $rates->penalty);
	Fpdf::Cell(70,0, number_format($penalty,2));
        Fpdf::ln(5);
        Fpdf::Cell(70,0,'Penalty Vat');
        Fpdf::Cell(70,0, 0.12);
        Fpdf::Cell(70,0, number_format($penaltyVat,2));
	Fpdf::ln(5);
         Fpdf::ln(5);
        Fpdf::Cell(40,0,'Disconnection-------------------------------------------------------------------------------------');
        Fpdf::SetFont('Courier','',9);
        Fpdf::ln(5);
        Fpdf::SetFont('Courier','',9);

	Fpdf::Cell(70,0,'Reconnection Fee');
	Fpdf::Cell(70,0, $rates->reconnection_fee);
	Fpdf::Cell(70,0, number_format(112,2));
	$sum = $sum + 112;

        Fpdf::ln(5);
        Fpdf::Cell(40,0,'--------------------------------------------------------------------------------------------------');
        Fpdf::ln(5);
        Fpdf::SetFont('Courier','B',13);
        Fpdf::Cell(70,0,'Total Amount Due after Charges');
        Fpdf::Cell(70,0, '');
        Fpdf::Cell(70,0,number_format($sum,2));
        Fpdf::ln(5);
        Fpdf::SetFont('Courier','b',9);
        Fpdf::ln(5);
        Fpdf::Cell(70,0,'Not Valid as Official Receipt');
        Fpdf::ln(5);
        Fpdf::Cell(70,0,'This becomes final if no complaint is received after 5 (five) days from receipt hereof');
        Fpdf::ln(5);
        Fpdf::Cell(70,0,'Please Present This statement when paying for your bill');

        Fpdf::Output();
        exit;
	}
}