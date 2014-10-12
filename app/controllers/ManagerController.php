<?php

use Quezelco\Interfaces\AuthRepository as Auth;
use Quezelco\Interfaces\UserRepository as User;
use Quezelco\Interfaces\AccountRepository as Account;
use Quezelco\Interfaces\BillRepository as Bill;
use Quezelco\Interfaces\RatesRepository as Rates;
use Carbon\Carbon;

class ManagerController extends BaseController{
	
	public function __construct(Auth $auth, User $user, Account $account, Bill $bill, Rates $rates){
		$this->auth = $auth;
		$this->account = $account;
		$this->rates = $rates;
		$this->user = $user;
		$this->bill = $bill;
	}
	public function showIndex(){
		//get user to get the id of the damn user
		$user = $this->auth->getCurrentUser();
		//get damn location out of the user
		$locations = $this->user->find($user->id)->locations()->get();
		//get all consumer accounts
		$id = $this->auth->findGroupByName('Consumer')->id;
		//arraying~
		$location_id = array();
		foreach($locations as $location){
			$location_id[] = $location->id;
		}
		$search_key = '';
		$users = $this->user->getManagerViewPaginated($id, $location_id);
		return View::make('manager.index', compact('users','search_key'));
	}

	public function changeStatus($id){
		$account = $this->account->find($id);
		$this->account->changeStatus($account);
		Session::flash('message','Status Updated');
		return Redirect::to('manager/home');
	}

	public function search(){
		//get user to get the id of the damn user
		$user = $this->auth->getCurrentUser();
		//get damn location out of the user
		$locations = $this->user->find($user->id)->locations()->get();
		//get all consumer accounts
		$id = $this->auth->findGroupByName('Consumer')->id;
		//arraying~
		$location_id = array();
		foreach($locations as $location){
			$location_id[] = $location->id;
		}
		$search_key = Input::get('search_key');
		$users = $this->user->searchManagerView($id, $location_id, $search_key);
		return View::make('manager.index', compact('users', 'search_key'));
	}

	public function generateAccountList(){
				Fpdf::AddPage();
				Fpdf::SetFont('Courier','B',16);
                Fpdf::Cell(190,10,'Quezelco Electronic Cooperative',0,1,'C');
                Fpdf::SetFont('Courier','',11);
                Fpdf::Cell(190,10,'Consumer List as of ' . Carbon::now(),0,1,'C');
                Fpdf::SetFont('Courier','','9');

        		Fpdf::SetFillColor(0);
                Fpdf::SetTextColor(255);
                Fpdf::SetFont('Courier','B');
                Fpdf::Cell(38, 10, "Account Number" , 1, 0, 'L', true);
                Fpdf::Cell(38, 10, "OEBR Number", 1, 0, 'L', true);
                Fpdf::Cell(38, 10, "Last Name" , 1, 0, 'L', true);
                Fpdf::Cell(38, 10, "First Name" , 1, 0, 'L', true);
                Fpdf::Cell(38, 10, "Branch" , 1, 0, 'L', true);
                Fpdf::Ln();

                //get user to get the id of the damn user
				$user = $this->auth->getCurrentUser();
				//get damn location out of the user
				$locations = $this->user->find($user->id)->locations()->get();
				//get all consumer accounts
				$id = $this->auth->findGroupByName('Consumer')->id;
				//arraying~
				$location_id = array();
				foreach($locations as $location){
					$location_id[] = $location->id;
				}

                $users = $this->user->getManagerView($id, $location_id);

                Fpdf::SetFillColor(255);
                Fpdf::SetTextColor(0);
                
                foreach($users as $user){
                	Fpdf::Cell(38, 6, $user->consumer()->first()->account_number, 1, 0, 'L', true);
                	Fpdf::Cell(38, 6, $user->consumer()->first()->oebr_number, 1, 0, 'L', true);
                	Fpdf::Cell(38, 6, $user->last_name, 1, 0, 'L', true);
                	Fpdf::Cell(38, 6, $user->first_name, 1, 0, 'L', true);
                	Fpdf::Cell(38, 6, $user->consumer->first()->routes()->first()->route_name, 1, 0, 'L', true);
                	Fpdf::Ln();
                }

                Fpdf::Output();
                exit;
	}

	public function generateDisconnectedList(){
			Fpdf::AddPage();
				Fpdf::SetFont('Courier','B',16);
                Fpdf::Cell(190,10,'Quezelco Electronic Cooperative',0,1,'C');
                Fpdf::SetFont('Courier','',11);
                Fpdf::Cell(190,10,'Disconnected List as of ' . Carbon::now(),0,1,'C');
                Fpdf::SetFont('Courier','','9');

        		Fpdf::SetFillColor(0);
                Fpdf::SetTextColor(255);
                Fpdf::SetFont('Courier','B');
                Fpdf::Cell(38, 10, "Account Number" , 1, 0, 'L', true);
                Fpdf::Cell(38, 10, "OEBR Number", 1, 0, 'L', true);
                Fpdf::Cell(38, 10, "Last Name" , 1, 0, 'L', true);
                Fpdf::Cell(38, 10, "First Name" , 1, 0, 'L', true);
                Fpdf::Cell(38, 10, "Branch" , 1, 0, 'L', true);
                Fpdf::Ln();

                //get user to get the id of the damn user
				$user = $this->auth->getCurrentUser();
				//get damn location out of the user
				$locations = $this->user->find($user->id)->locations()->get();
				//get all consumer accounts
				$id = $this->auth->findGroupByName('Consumer')->id;
				//arraying~
				$location_id = array();
				foreach($locations as $location){
					$location_id[] = $location->id;
				}

                $users = $this->user->getDisconnectedManagerView($id, $location_id);
                Fpdf::SetFillColor(255);
                Fpdf::SetTextColor(0);
                

                foreach($users as $user){
                	Fpdf::Cell(38, 6, $user->consumer()->first()->account_number, 1, 0, 'L', true);
                	Fpdf::Cell(38, 6, $user->consumer()->first()->oebr_number, 1, 0, 'L', true);
                	Fpdf::Cell(38, 6, $user->last_name, 1, 0, 'L', true);
                	Fpdf::Cell(38, 6, $user->first_name, 1, 0, 'L', true);
                	Fpdf::Cell(38, 6, $user->consumer->first()->routes()->first()->route_name, 1, 0, 'L', true);
                	Fpdf::Ln();
                }

                Fpdf::Output();
                exit;
	}

	public function printBillingStatement($id){
		$bill = $this->bill->findNextPaymentById($id);
		$rates = $this->rates->getRates();

		if(is_null($bill)){
			Session::flash('message','No Unpaid Bills for this Account!');
			return Redirect::to('manager/home');
		}
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
	$penalty = $sum * 0.12;
        $penaltyVat = $penalty * 0.12;
	$sum = $sum + $penalty;
	$penalty = $penalty - $penaltyVat;
        Fpdf::ln(5);
        Fpdf::Cell(40,0,'Penalties-----------------------------------------------------------------------------------------');
        Fpdf::ln(5);
        Fpdf::SetFont('Courier','',9);
        Fpdf::ln(5);
        Fpdf::Cell(70,0,'Penalty');
	Fpdf::Cell(70,0, 0.12);
	Fpdf::Cell(70,0, number_format($penalty,2));
        Fpdf::ln(5);
        Fpdf::Cell(70,0,'Penalty Vat (12%)');
        Fpdf::Cell(70,0, 0.12);
        Fpdf::Cell(70,0, number_format($penaltyVat,2));
	Fpdf::ln(5);
         Fpdf::ln(5);
        Fpdf::Cell(40,0,'Disconnection-------------------------------------------------------------------------------------');
        Fpdf::SetFont('Courier','',9);
        Fpdf::ln(5);
        Fpdf::SetFont('Courier','',9);

	Fpdf::Cell(70,0,'Reconnection Fee');
	Fpdf::Cell(70,0, 112);
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